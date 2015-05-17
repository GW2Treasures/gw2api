<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GW2Treasures\GW2Api\V2\Endpoint;

use GW2Treasures\GW2Api\V2\Interfaces\ILocalizedEndpoint;

class LocalizedEndpointProxy extends Endpoint implements ILocalizedEndpoint {
    /** @var Endpoint $origin */
    private $origin;

    /** @var string $lang */
    private $lang;

    /**
     * @param Endpoint $origin
     * @param string   $lang
     */
    public function __construct( Endpoint $origin, $lang ) {
        $this->origin = $origin;
        $this->lang = $lang;
    }

    /**
     * Dark magic, rebinding the origin method to $this context
     *
     * @todo: find a way that doesn't involve reflection, rebinding, ... to do this.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call( $name, $arguments ) {
        $method = new \ReflectionMethod( $this->origin, $name );
        if( !is_null( $method )) {
            $closure = $method->getClosure( $this->origin )->bindTo( $this, $this->origin );
            return call_user_func_array( $closure, $arguments );
        } else {
            trigger_error( 'Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR );
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $query = [ 'lang' => $this->lang ] + $query;
        return $this->origin->createRequest( $query, $url, $method, $options );
    }

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return $this->origin->url();
    }

    /**
     * {@inheritdoc}
     */
    protected function getClient() {
        return $this->origin->getClient();
    }

    /**
     * @param string $language
     * @return $this
     */
    public function lang( $language ) {
        return new LocalizedEndpointProxy( $this->origin, $language );
    }

    /**
     * String representation of this localized endpoint.
     *
     * @return string
     */
    function __toString() {
        return '[' . get_class( $this ) .
               '<' . get_class( $this->origin ) . '(' . $this->url() . ')>' .
               '(' . $this->lang . ')]';
    }
}
