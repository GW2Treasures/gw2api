<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\IEndpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

abstract class TestCase extends PHPUnit_Framework_TestCase {
    /** @var GW2Api $api */
    protected $api;

    /** @var MockHandler $mock */
    protected $mock;

    /** @var array $history */
    protected $history = [];

    /**
     * @return GW2Api
     */
    protected function api() {
        if( !isset( $this->api )) {
            $this->mock = new MockHandler();
            $stack = HandlerStack::create($this->mock);
            $stack->push(Middleware::history($this->history));

            $this->api = new GW2Api(['handler' => $stack]);
        }
        return $this->api;
    }

    /**
     * @param Response|RequestException|string $response
     * @param string $language
     */
    protected function mockResponse( $response, $language = 'en' ) {
        $this->api();

        if( is_string( $response )) {
            $this->mock->append(
                new Response( 200, [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Content-Language' => $language
                ], Psr7\stream_for( $response ))
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
        $transaction = end($this->history);
        return $transaction['request'];
    }

    /**
     * @return RequestInterface[]
     */
    protected function getRequests() {
        $requests = [];
        foreach( $this->history as $transaction ) {
            $requests[] = $transaction['request'];
        }
        return $requests;
    }

    /**
     * Asserts that the given header exists.
     *
     * If provided with a value, the value of the header will also be compared.
     *
     * @param MessageInterface $message
     * @param string $name
     * @param string|array|null $value
     */
    public function assertHasHeader(MessageInterface $message, $name, $value = null) {
        $this->assertTrue( $message->hasHeader( $name ), "The message does not contain the header $name." );

        if( !is_null( $value )) {
            $header = $message->getHeader( $name );

            if( count( $header ) === 1 && is_string( $value )) {
                $this->assertEquals( $value, array_shift( $header ),
                    "The message contains the header $name, but with the wrong value.");
            } else {
                $this->assertEquals( $value, $header,
                    "The message contains the header $name, but with the wrong value." );
            }
        }
    }

    /**
     * Asserts that the response does not contain the specified header.
     *
     * @param MessageInterface $message
     * @param string $name
     */
    public function assertHasNotHeader(MessageInterface $message, $name) {
        $this->assertFalse( $message->hasHeader( $name ),
            "The message contains the header $name" );
    }

    /**
     * Asserts that the query string of the request contains the specified query parameter.
     *
     * If value is provided, the value will also be comaped
     *
     * @param RequestInterface $request
     * @param string $name
     * @param string|null $value
     */
    public function assertHasQuery(RequestInterface $request, $name, $value = null) {
        $query = Psr7\parse_query( $request->getUri()->getQuery() );

        $this->assertArrayHasKey( $name, $query, "The request does not contain the query parameter $name");

        if( !is_null( $value )) {
            $this->assertEquals( $value, $query[$name],
                "The request contains the query parameter $name, but with the wrong value." );
        }
    }

    public function assertEndpointIsAuthenticated( IEndpoint $endpoint ) {
        $this->assertInstanceOf( IAuthenticatedEndpoint::class, $endpoint );
        $this->assertNotNull( $endpoint->getApiKey() );
    }

    public function assertEndpointIsBulk( IEndpoint $endpoint ) {
        $this->assertInstanceOf( IBulkEndpoint::class, $endpoint );
    }

    public function assertEndpointIsLocalized( IEndpoint $endpoint ) {
        $this->assertInstanceOf( ILocalizedEndpoint::class, $endpoint );
    }

    public function assertEndpointIsPaginated( IEndpoint $endpoint ) {
        $this->assertInstanceOf( IPaginatedEndpoint::class, $endpoint );
    }

    /**
     * @param string    $expected
     * @param IEndpoint $endpoint
     */
    public function assertEndpointUrl( $expected, IEndpoint $endpoint ) {
        $this->assertEquals( $expected, $endpoint->url() );
    }
}
