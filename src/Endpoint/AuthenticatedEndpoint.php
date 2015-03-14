<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GW2Treasures\GW2Api\Request\RequestManager;

abstract class AuthenticatedEndpoint extends Endpoint {
    protected $_token;

    public function __construct( RequestManager $requestManager, $token ) {
        parent::__construct( $requestManager );
        $this->_token = $token;
    }

    /**
     * {@inheritdoc}
     */
    protected function request( array $query = [] ) {
        return $this->requestManager->request( $this->url(), $query, ['Authorization' => 'Bearer ' . $this->_token ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function requestMany( array $queries ) {
        return $this->requestManager->request( $this->url(), $queries, ['Authorization' => 'Bearer ' . $this->_token ]);
    }
}
