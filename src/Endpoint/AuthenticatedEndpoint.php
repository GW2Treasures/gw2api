<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;

abstract class AuthenticatedEndpoint extends Endpoint {
    protected $apiKey;

    public function __construct( Client $client, $apiKey, array $options = [] ) {
        parent::__construct( $client, $options );
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $options = [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey ]] + $options;
        return parent::createRequest( $query, $url, $method, $options );
    }
}
