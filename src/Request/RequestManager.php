<?php

namespace GW2Treasures\GW2Api\Request;

abstract class RequestManager {

    /** @var string $baseUrl */
    protected $baseUrl;

    protected $useragent;

    function __construct( $baseUrl ) {
        $this->baseUrl = $baseUrl;
    }

    public function getCertPath() {
        return __DIR__ . DIRECTORY_SEPARATOR . 'cacert.pem';
    }

    /**
     * @param string   $url
     * @param string[] $query
     * @param string[] $header
     * @return Response
     */
    public abstract function request( $url, array $query = [], array $header = [] );

    /**
     * @param string     $url
     * @param string[][] $queries
     * @param string[]   $header
     */
    public abstract function requestMany( $url, array $queries, array $header = [] );

    /**
     * @param string $useragent
     */
    public function setUseragent( $useragent) {
        $this->useragent = $useragent;
    }
}
