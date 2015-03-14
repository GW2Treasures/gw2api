<?php

use GW2Treasures\GW2Api\GW2Api;

abstract class TestCase extends PHPUnit_Framework_TestCase {
    protected $api;

    protected function api() {
        $this->api = $this->api ?: new GW2Api();
        return $this->api;
    }

    protected function setUp() {
        ini_set('memory_limit','256M');
    }
}
