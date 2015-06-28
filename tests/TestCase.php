<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;
use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\IEndpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;

abstract class TestCase extends PHPUnit_Framework_TestCase {
    /** @var GW2Api $api */
    protected $api;

    /** @var Mock $mock */
    protected $mock;

    /** @var History $history */
    protected $history;

    /**
     * @return GW2Api
     */
    protected function api() {
        $this->api = $this->api ?: new GW2Api();
        return $this->api;
    }

    /**
     * @param Response|RequestException|string $response
     */
    protected function mockResponse( $response, $language = 'en' ) {
        if( !isset( $this->mock )) {
            $this->mock = new Mock();
            $this->history = new History();
            $this->api()->getClient()->getEmitter()->attach( $this->mock );
            $this->api()->getClient()->getEmitter()->attach( $this->history );
        }
        if( is_string( $response )) {
            $this->mock->addResponse(
                new Response( 200, ['Content-Type' => 'application/json; charset=utf-8', 'Content-Language' => $language], Stream::factory( $response ))
            );
        } elseif( $response instanceof RequestException ) {
            $this->mock->addException( $response );
        } else {
            $this->mock->addResponse( $response );
        }
    }

    /**
     * @return RequestInterface
     */
    protected function getLastRequest() {
        return $this->history->getLastRequest();
    }

    public function assertEndpointIsAuthenticated( IEndpoint $endpoint ) {
        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint', $endpoint );
    }

    public function assertEndpointIsBulk( IEndpoint $endpoint ) {
        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint', $endpoint );
    }

    public function assertEndpointIsLocalized( IEndpoint $endpoint ) {
        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint', $endpoint );
    }

    public function assertEndpointIsPaginated( IEndpoint $endpoint ) {
        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint', $endpoint );
    }
}
