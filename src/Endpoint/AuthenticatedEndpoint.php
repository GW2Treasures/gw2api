<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;

abstract class AuthenticatedEndpoint extends Endpoint {
    protected $_token;

    public function __construct( Client $client, $token, array $options = [] ) {
        parent::__construct( $client, $options );
        $this->_token = $token;
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $options = [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->_token ]] + $options;
        return parent::createRequest( $query, $url, $method, $options );
    }
}
