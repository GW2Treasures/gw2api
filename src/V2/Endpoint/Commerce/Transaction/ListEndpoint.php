<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\V2\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Interfaces\IPaginatedEndpoint;
use GW2Treasures\GW2Api\V2\PaginatedEndpoint;
use InvalidArgumentException;

class ListEndpoint extends AuthenticatedEndpoint implements IPaginatedEndpoint {
    use PaginatedEndpoint;

    protected static $types = [ 'current', 'history' ];
    protected static $lists = [ 'buys', 'sells' ];

    /** @var string $type */
    protected $type;

    /** @var string $list */
    protected $list;

    public function __construct( Client $client, $apiKey, $type, $list, array $options = [ ] ) {
        if( !in_array( $type, self::$types )) {
            throw new InvalidArgumentException(
                'Invalid $type ("' . $type . '""), has to be one of: ' . implode(', ', self::$types)
            );
        }

        if( !in_array( $list, self::$lists )) {
            throw new InvalidArgumentException(
                'Invalid $list ("' . $list . '""), has to be one of: ' . implode(', ', self::$lists)
            );
        }

        $this->type = $type;
        $this->list = $list;

        parent::__construct( $client, $apiKey, $options );
    }

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/transactions/' . $this->type . '/' . $this->list;
    }
}
