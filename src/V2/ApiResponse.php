<?php

namespace GW2Treasures\GW2Api\V2;

use Psr\Http\Message\ResponseInterface;

class ApiResponse {
    /** @var ResponseInterface $response*/
    protected $response;

    public function __construct( ResponseInterface $response ) {
        $this->response = $response;
    }

    /**
     * Get the response.
     *
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Get the response as json object.
     *
     * @param array $config
     * @return mixed
     */
    public function json( array $config = [] ) {
        $options = isset($config['big_int_strings']) ? JSON_BIGINT_AS_STRING : 0;
        return json_decode($this->response->getBody(), false, 512, $options);
    }
}
