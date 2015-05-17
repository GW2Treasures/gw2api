<?php

namespace GW2Treasures\GW2Api;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\V2\Endpoint\Account\AccountEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Build\BuildEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Color\ColorEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Commerce\CommerceEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Continent\ContinentEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\File\FileEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Item\ItemEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Map\MapEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Quaggan\QuagganEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Recipe\RecipeEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Skin\SkinEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\World\WorldEndpoint;

class GW2Api {
    /** @var string $apiUrl */
    protected $apiUrl = 'https://api.guildwars2.com/';

    /** @var Client $client */
    protected $client;

    /** @var array $options */
    protected $options;

    function __construct( array $options = [] ) {
        $this->options = $this->getOptions( $options );

        $this->client = new Client( $this->options );
        $this->options = $options;
    }

    protected function getOptions( array $options = [] ) {
        return [
           'base_url' => $this->apiUrl,
           'defaults' => [
               'verify' => __DIR__ . DIRECTORY_SEPARATOR . 'cacert.pem'
           ]
        ] + $options;
    }

    public function getClient() {
        return $this->client;
    }

    public function account( $apiKey ) {
        return new AccountEndpoint( $this->client, $apiKey );
    }

    public function build() {
        return new BuildEndpoint( $this->client );
    }

    public function colors() {
        return new ColorEndpoint( $this->client );
    }

    public function commerce() {
        return new CommerceEndpoint( $this->client );
    }

    public function continents() {
        return new ContinentEndpoint( $this->client );
    }

    public function files() {
        return new FileEndpoint( $this->client );
    }

    public function items() {
        return new ItemEndpoint( $this->client );
    }

    public function maps() {
        return new MapEndpoint( $this->client );
    }

    public function quaggans() {
        return new QuagganEndpoint( $this->client );
    }

    public function recipes() {
        return new RecipeEndpoint( $this->client );
    }

    public function skins() {
        return new SkinEndpoint( $this->client );
    }

    public function worlds() {
        return new WorldEndpoint( $this->client );
    }
}
