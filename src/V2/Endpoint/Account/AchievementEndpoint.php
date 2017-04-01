<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account;

use Exception;
use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;

class AchievementEndpoint extends Endpoint implements IAuthenticatedEndpoint, IPaginatedEndpoint, IBulkEndpoint {
    use AuthenticatedEndpoint, BulkEndpoint {
        BulkEndpoint::get as private bulkGet;
        BulkEndpoint::ids as private bulkIds;
    }

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/account/achievements';
    }

    public function get($id = null) {
        if($id == null) {
            return $this->all();
        } else {
            return $this->bulkGet($id);
        }
    }

    /**
     * This endpoint doesn't support ids()!
     *
     * @deprecated This endpoint doesn't support ids()!
     * @throws Exception
     * @return void
     */
    public function ids() {
        throw new Exception($this->url()." doesn't support ids().");
    }
}
