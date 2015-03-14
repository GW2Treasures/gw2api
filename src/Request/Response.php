<?php

namespace GW2Treasures\GW2Api\Request;

abstract class Response {

    /**
     * All headers of this Response.
     *
     * @return string[]
     */
    public abstract function headers();

    /**
     * Body of this Response as plain text.
     *
     * @return string
     */
    public abstract function body();

    /**
     * Status code of this Response.
     *
     * @return int
     */
    public abstract function status();

    /**
     * Specific header of this Response.
     *
     * @param string $name
     * @param null   $default
     * @return null|string
     */
    public function header( $name, $default = null ) {
        $headers = $this->headers();
        return array_key_exists( $name, $headers )
            ? $headers[ $name ]
            : $default;
    }

    /**
     * Content of this Response parsed as json.
     *
     * @return mixed
     */
    public function json() {
        return json_decode( $this->body() );
    }
}
