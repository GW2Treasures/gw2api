<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use InvalidArgumentException;

class TypeEndpoint extends AuthenticatedEndpoint {

    protected static $types = [ 'current', 'history' ];

    /** @var string $type */
    protected $type;

    public function __construct( GW2Api $api, $apiKey, $type ) {
        if( !in_array( $type, self::$types )) {
            throw new InvalidArgumentException(
                'Invalid $type ("' . $type . '""), has to be one of: ' . implode(', ', self::$types)
            );
        }

        $this->type = $type;

        parent::__construct( $api, $apiKey );
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
     * @return ListEndpoint
     */
    public function buys() {
        return new ListEndpoint( $this->getApi(), $this->apiKey, $this->type, 'buys' );
    }

    /**
     * Get pending/completed sell transactions.
     *
     * @return ListEndpoint
     */
    public function sells() {
        return new ListEndpoint( $this->getApi(), $this->apiKey, $this->type, 'sells' );
    }
}
