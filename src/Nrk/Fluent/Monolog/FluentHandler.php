<?php

/*
 * This file is part of the monolog-fluent package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nrk\Fluent\Monolog;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Fluent\Logger\FluentLogger;
use Fluent\Logger\ConsoleLogger;
use Fluent\Logger\HttpLogger;

/**
 * Simple Monolog handler for the Fluent event collector system.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 * @link http://fluentd.org
 */
class FluentHandler extends AbstractProcessingHandler
{
    protected $parameters;
    protected $logger;

    /**
     * Initializes a new Fluent handler and guesses the right protocol to use
     * from the passed URI.
     *
     * @param string $fluentURI URI that identifies the fluentd instance.
     */
    public function __construct($fluentURI, $level = Logger::ERROR, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->parameters = parse_url($fluentURI);
    }

    /**
     * Creates a new Fluent logger instances.
     *
     * @param Array $parameters Parameters used to initialize the underlying logger.
     * @param string $tag Full tag name to identify the log in fluent.
     */
    protected function initializeLogger(Array $parameters, $tag)
    {
        if (!isset($parameters['scheme'])) {
            $parameters['scheme'] = 'http';
        }

        switch ($parameters['scheme']) {
            case 'http':
                $host = isset($parameters['host']) ? $parameters['host'] : '127.0.0.1';
                $port = isset($parameters['port']) ? $parameters['port'] : HttpLogger::DEFAULT_HTTP_PORT;
                $this->logger = new HttpLogger($tag, $host, $port);
                break;

            case 'tcp':
            case 'fluent':
                $host = isset($parameters['host']) ? $parameters['host'] : FluentLogger::DEFAULT_ADDRESS;
                $port = isset($parameters['port']) ? $parameters['port'] : FluentLogger::DEFAULT_LISTEN_PORT;
                $this->logger = new FluentLogger($tag, $host, $port);
                break;

            case 'php':
                $handle = fopen("{$parameters['scheme']}://{$parameters['host']}", 'w');
                $this->logger = new ConsoleLogger($tag, $handle);
                break;

            default:
                throw new \RuntimeException("The specified protocol is not supported [$scheme]");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!isset($this->logger)) {
            $this->initializeLogger($this->parameters, $record['channel']);
        }

        unset($record['formatted'], $record['datetime']);

        $this->logger->post($record);
    }
}
