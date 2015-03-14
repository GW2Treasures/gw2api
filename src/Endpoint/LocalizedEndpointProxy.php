<?php

namespace GW2Treasures\GW2Api\Endpoint;

class LocalizedEndpointProxy extends Endpoint {
    /** @var Endpoint $origin */
    private $origin;

    /** @var string $lang */
    private $lang;

    /**
     * @param Endpoint $origin
     * @param string            $lang
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
        if( is_callable([ $this->origin, $name ])) {
            $method = new \ReflectionMethod( $this->origin, $name );
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
    protected function request( array $query = [] ) {
        return $this->origin->request( [ 'lang' => $this->lang ] + $query );
    }

    /**
     * {@inheritdoc}
     */
    protected function requestMany( array $queries ) {
        $queries = array_map( function( $query ) {
            return [ 'lang' => $this->lang ] + $query;
        }, $queries );
        return $this->origin->requestMany( $queries );
    }


    /**
     * {@inheritdoc}
     */
    protected function url() {
        return $this->origin->url();
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
