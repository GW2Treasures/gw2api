<?php

namespace GW2Treasures\GW2Api\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ApiException extends Exception {
    /** @var ResponseInterface $response */
    protected $response;

    public function __construct( $message = "", ResponseInterface $response ) {
        $this->response = $response;

        parent::__construct( $message, $response->getStatusCode() );
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    public function __toString() {
        $status = $this->response->getStatusCode();
        $url = $this->response->getHeaderLine('X-GUZZLE-EFFECTIVE-URL');

        return "$this->message (status: $status; url: $url)";
    }
}
