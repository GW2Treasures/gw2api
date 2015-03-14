<?php

namespace GW2Treasures\GW2Api\Request\RollingCurl;

use GW2Treasures\GW2Api\Request\Response as AbstractResponse;
use RollingCurl\Request;

class Response extends AbstractResponse {
    /** @var string $body */
    protected $body;

    /** @var string[] $headers */
    protected $headers;

    /** @var int $status */
    protected $status;

    public function __construct( Request $request ) {
        $this->parseResponse( $request );
    }

    /**
     * @param Request $request
     */
    protected function parseResponse( Request $request ) {
        $info = $request->getResponseInfo();
        $text = $request->getResponseText();
        $header_size = $info['header_size'];

        $headerRaw = trim( substr( $text, 0, $header_size ));
        $headers = array();
        foreach( explode( "\n", $headerRaw ) as $i => $line ) {
            if( $i === 0 ) {
                $headers['http_code'] = trim($line);
            } else {
                list( $key, $value ) = explode( ': ', $line, 2 );
                $headers[ trim( $key ) ] = trim( $value );
            }
        }

        $this->status = $info['http_code'];
        $this->headers = $headers;
        $this->body = substr( $text, $header_size );
    }

    /**
     * {@inheritdoc}
     */
    public function headers() {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function body() {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function status() {
        return $this->status;
    }
}
