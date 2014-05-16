<?php

/**
 * This file is part of Laravel Dropbox by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\Dropbox\Classes;

use Mockery;
use GrahamCampbell\Dropbox\Connectors\ConnectionFactory;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the connection factory test class.
 *
 * @package    Laravel-Dropbox
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Dropbox/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Dropbox
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $factory = $this->getMockedFactory();

        $return = $factory->make(array('driver' => 'dropbox', 'token' => 'your-token', 'app' => 'your-app', 'name' => 'dropbox'));

        $this->assertInstanceOf('Dropbox\Client', $return);
    }

    public function testCreateDropboxConnector()
    {
        $factory = $this->getConnectionFactory();

        $return = $factory->createConnector(array('driver' => 'dropbox'));

        $this->assertInstanceOf('GrahamCampbell\Dropbox\Connectors\DropboxConnector', $return);
    }

    public function testCreateEmptyDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $return = null;

        try {
            $factory->createConnector(array());
        } catch (\Exception $e) {
            $return = $e;
        }

        $this->assertInstanceOf('InvalidArgumentException', $return);
    }

    public function testCreateUnsupportedDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $return = null;

        try {
            $factory->createConnector(array('driver' => 'unsupported'));
        } catch (\Exception $e) {
            $return = $e;
        }

        $this->assertInstanceOf('InvalidArgumentException', $return);
    }

    protected function getConnectionFactory()
    {
        return new ConnectionFactory();
    }

    protected function getMockedFactory()
    {
        $mock = Mockery::mock('GrahamCampbell\Dropbox\Connectors\ConnectionFactory[createConnector]');

        $connectory = Mockery::mock('GrahamCampbell\Dropbox\Connectors\LocalConnector');

        $connectory->shouldReceive('connect')->once()
            ->with(array('name' => 'dropbox', 'driver' => 'dropbox', 'token' => 'your-token', 'app' => 'your-app'))
            ->andReturn(Mockery::mock('Dropbox\Client'));

        $mock->shouldReceive('createConnector')->once()
            ->with(array('name' => 'dropbox', 'driver' => 'dropbox', 'token' => 'your-token', 'app' => 'your-app'))
            ->andReturn($connectory);

        return $mock;
    }
}
