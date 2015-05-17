<?php

namespace GW2Treasures\GW2Api;

use GuzzleHttp\Client;
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
