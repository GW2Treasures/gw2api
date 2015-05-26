<?php

namespace GW2Treasures\GW2Api;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\V2\Endpoint\Account\AccountEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Build\BuildEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Character\CharacterEndpoint;
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
use GW2Treasures\GW2Api\V2\IEndpoint;

class GW2Api {
    /** @var string $apiUrl */
    protected $apiUrl = 'https://api.guildwars2.com/';

    /** @var Client $client */
    protected $client;

    /** @var array $options */
    protected $options;

    /** @var array $handlers */
    protected $handlers = [];

    function __construct( array $options = [] ) {
        $this->options = $this->getOptions( $options );

        $this->client = new Client( $this->options );
        $this->options = $options;

        $this->registerHandler( '\GW2Treasures\GW2Api\V2\Authentication\AuthenticationHandler' );
        $this->registerHandler( '\GW2Treasures\GW2Api\V2\Localization\LocalizationHandler' );
        $this->registerHandler( '\GW2Treasures\GW2Api\V2\Pagination\PaginationHandler' );
    }

    protected function getOptions( array $options = [] ) {
        return [
           'base_url' => $this->apiUrl,
           'defaults' => [
               'verify' => __DIR__ . DIRECTORY_SEPARATOR . 'cacert.pem'
           ]
        ] + $options;
    }

    /**
     * @param string $handler
     */
    public function registerHandler( $handler ) {
        if( is_null( $handler )) {
            throw new \InvalidArgumentException( '$handler can\'t be null' );
        }

        if( !is_string( $handler )) {
            throw new \InvalidArgumentException( '$handler has to be a string (class name of a valid ApiHandler)' );
        }

        $handlerClass = new \ReflectionClass( $handler );
        if( !$handlerClass->isSubclassOf( '\GW2Treasures\GW2Api\V2\ApiHandler' )) {
            throw new \InvalidArgumentException( '$handler has to be a ApiHandler');
        }

        $firstConstructorParameter = $handlerClass->getConstructor()->getParameters()[0];
        $this->handlers[ $handler ] = $firstConstructorParameter->getClass()->getName();
    }

    public function getClient() {
        return $this->client;
    }

    public function account( $apiKey ) {
        return new AccountEndpoint( $this, $apiKey );
    }

    public function build() {
        return new BuildEndpoint( $this );
    }

    public function characters( $apiKey ) {
        return new CharacterEndpoint( $this, $apiKey );
    }

    public function colors() {
        return new ColorEndpoint( $this );
    }

    public function commerce() {
        return new CommerceEndpoint( $this );
    }

    public function continents() {
        return new ContinentEndpoint( $this );
    }

    public function files() {
        return new FileEndpoint( $this );
    }

    public function items() {
        return new ItemEndpoint( $this );
    }

    public function maps() {
        return new MapEndpoint( $this );
    }

    public function quaggans() {
        return new QuagganEndpoint( $this );
    }

    public function recipes() {
        return new RecipeEndpoint( $this );
    }

    public function skins() {
        return new SkinEndpoint( $this );
    }

    public function worlds() {
        return new WorldEndpoint( $this );
    }

    public function attachRegisteredHandlers( IEndpoint $endpoint ) {
        foreach( $this->handlers as $handler => $handles ) {
            if( is_a( $endpoint, $handles )) {
                $endpoint->attach( new $handler( $endpoint ) );
            }
        }
    }
}
