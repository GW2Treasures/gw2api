<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;

abstract class Endpoint {
    /** @var Client $client */
    protected $client;

    /** @var array $options */
    private $options;

    /**
     * @param Client $client
     * @param array  $options
     */
    public function __construct( Client $client, array $options = [] ) {
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * @return Client
     */
    protected function getClient() {
        return $this->client;
    }

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[] $query
     * @param null     $url
     * @param string   $method
     * @param array    $options
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $url = !is_null( $url ) ? $url : $this->url();
        return $this->client->createRequest( $method, $url, $options + [ 'query' => $query ]);
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    protected abstract function url();

    /**
     * String representation of this endpoint.
     *
     * @return string
     */
    function __toString() {
        return '[' . get_class( $this ) . '(' . $this->url() . ']';
    }
}
