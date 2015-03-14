<?php

namespace GW2Treasures\GW2Api;

use GW2Treasures\GW2Api\Endpoint\V2\AccountEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\BuildEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\ColorEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\CommerceEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\ContinentEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\FileEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\ItemEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\MapEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\QuagganEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\RecipeEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\SkinEndpoint;
use GW2Treasures\GW2Api\Endpoint\V2\WorldEndpoint;
use GW2Treasures\GW2Api\Request\RequestManager;
use GW2Treasures\GW2Api\Request\RollingCurl\RequestManager as RollingCurlRequestManager;

class GW2Api {
    /** @var RequestManager $requestManager */
    protected $requestManager;

    /** @var string $apiUrl */
    protected $apiUrl = 'https://api.guildwars2.com/';

    function __construct( RequestManager $requestManager = null ) {
        $this->requestManager = $requestManager ?: new RollingCurlRequestManager( $this->apiUrl );
    }

    public function account( $access_token ) {
        return new AccountEndpoint( $this->requestManager, $access_token );
    }

    public function build() {
        return new BuildEndpoint( $this->requestManager );
    }

    public function colors() {
        return new ColorEndpoint( $this->requestManager );
    }

    public function commerce() {
        return new CommerceEndpoint( $this->requestManager );
    }

    public function continents() {
        return new ContinentEndpoint( $this->requestManager );
    }

    public function files() {
        return new FileEndpoint( $this->requestManager );
    }

    public function items() {
        return new ItemEndpoint( $this->requestManager );
    }

    public function maps() {
        return new MapEndpoint( $this->requestManager );
    }

    public function quaggans() {
        return new QuagganEndpoint( $this->requestManager );
    }

    public function recipes() {
        return new RecipeEndpoint( $this->requestManager );
    }

    public function skins() {
        return new SkinEndpoint( $this->requestManager );
    }

    public function worlds() {
        return new WorldEndpoint( $this->requestManager );
    }
}
