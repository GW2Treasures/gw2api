<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Message\ResponseInterface;

class ApiResponse {
    /** @var ResponseInterface $response*/
    protected $response;

    public function __construct( ResponseInterface $response ) {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param array $config
     * @return mixed
     */
    public function json( array $config = [] ) {
        return $this->response->json( ['object' => true] + $config );
    }
}
