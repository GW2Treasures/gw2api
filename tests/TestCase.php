<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use GuzzleHttp\Handler\MockHandler;
use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\IEndpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;

abstract class TestCase extends PHPUnit_Framework_TestCase {
    /** @var GW2Api $api */
    protected $api;

    /** @var MockHandler $mock */
    protected $mock;

    /** @var callable $history */
    protected $history;

    /** @var  @var array $container */
    protected $container;

    /**
     * @return GW2Api
     */
    protected function api() {
        if( !isset( $this->api )) {
            $this->mock = new MockHandler();
            $this->container = [];
            $this->history = Middleware::history($this->container);
            $stack = HandlerStack::create($this->mock);
            $stack->push($this->history);
            $this->api = new GW2Api(['handler' => $stack]);
        }
        return $this->api;
    }

    /**
     * @param Response|RequestException|string $response
     */
    protected function mockResponse( $response, $language = 'en' ) {
        if( !isset( $this->mock )) {
            $this->api();
        }
        if( is_string( $response )) {
            $this->mock->append(
                new Response( 200, ['Content-Type' => 'application/json; charset=utf-8', 'Content-Language' => $language], Psr7\stream_for( $response ))
            );
        } elseif( $response instanceof RequestException ) {
            $this->mock->append( $response );
        } else {
            $this->mock->append( $response );
        }
    }

    /**
     * @return RequestInterface
     */
    protected function getLastRequest() {
        $transaction = end($this->container);
        return $transaction['request'];
    }

    /**
     * @return RequestInterface[]
     */
    protected function getRequests() {
        $requests = [];
        foreach ($this->container AS $transaction) {
            $requests[] = $transaction['request'];
        }
        return $requests;
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    protected function getQueryArray(RequestInterface $request) {
        $query = $request->getUri()->getQuery();
        $pairs = explode('&', $query);
        $query_array = [];
        foreach ($pairs AS $pair) {
            if (empty($pair)) {
                continue;
            }
            list($key, $value) = explode('=', $pair);
            $query_array[$key] = $value;
        }
        return $query_array;
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

    /**
     * @param string    $expected
     * @param IEndpoint $endpoint
     */
    public function assertEndpointUrl( $expected, IEndpoint $endpoint ) {
        $this->assertEquals( $expected, $endpoint->url() );
    }
}
