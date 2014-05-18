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
use GrahamCampbell\Dropbox\Dropbox\DropboxConnector;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the dropbox connector test class.
 *
 * @package    Laravel-Dropbox
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Dropbox/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Dropbox
 */
class DropboxConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getDropboxConnector();

        $return = $connector->connect(array(
            'token'  => 'your-token',
            'app'    => 'your-app'
        ));

        $this->assertInstanceOf('Dropbox\Client', $return);
    }

    public function testConnectWithoutToken()
    {
        $connector = $this->getDropboxConnector();

        $return = null;

        try {
            $connector->connect(array('app' => 'your-app'));
        } catch (\Exception $e) {
            $return = $e;
        }

        $this->assertInstanceOf('InvalidArgumentException', $return);
    }

    public function testConnectWithoutSecret()
    {
        $connector = $this->getDropboxConnector();

        $return = null;

        try {
            $connector->connect(array('token' => 'your-token'));
        } catch (\Exception $e) {
            $return = $e;
        }

        $this->assertInstanceOf('InvalidArgumentException', $return);
    }

    protected function getDropboxConnector()
    {
        return new DropboxConnector();
    }
}
