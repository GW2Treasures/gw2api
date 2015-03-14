<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GW2Treasures\GW2Api\Request\RequestManager;

abstract class Endpoint {

    /** @var RequestManager requestManager */
    protected $requestManager;

    /**
     * @param RequestManager $requestManager
     */
    public function __construct( RequestManager $requestManager ) {
        $this->requestManager = $requestManager;
    }

    /**
     * Make a request.
     *
     * @param string[] $query
     * @return \GW2Treasures\GW2Api\Request\Response
     */
    protected function request( array $query = [] ) {
        return $this->requestManager->request( $this->url(), $query );
    }

    /**
     * Make multiple requests at once. If the RequestManager supports parallel requests, this will be way faster.
     * Otherwise the RequestManager will fallback to multiple simple requests.
     *
     * @param string[][] $queries
     * @return \GW2Treasures\GW2Api\Request\Response[]
     */
    protected function requestMany( array $queries ) {
        return $this->requestManager->requestMany( $this->url(), $queries );
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
