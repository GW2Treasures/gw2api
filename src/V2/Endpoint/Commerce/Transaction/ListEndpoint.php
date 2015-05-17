<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\V2\AuthenticatedEndpoint;
use InvalidArgumentException;

// TODO: should support pagination
class ListEndpoint extends AuthenticatedEndpoint {

    protected static $types = [ 'current', 'history' ];

    /** @var string $type The type of the list (one of self::$types) */
    protected $type;

    public function __construct( Client $client, $apiKey, $type, array $options = [ ] ) {
        if( !in_array( $type, self::$types )) {
            throw new InvalidArgumentException(
                'Invalid $type ("' . $type . '""), has to be one of: ' . implode(', ', self::$types)
            );
        }

        $this->type = $type;

        parent::__construct( $client, $apiKey, $options );
    }


    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/transactions/' . $this->type;
    }

    /**
     * Get pending/completed buy transactions.
     *
     * @return array
     */
    public function buys() {
        $request = $this->createRequest( [], $this->url() . '/buys' );
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
    }

    /**
     * Get pending/completed sell transactions.
     *
     * @return mixed
     */
    public function sells() {
        $request = $this->createRequest( [], $this->url() . '/sells' );
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
    }
}
