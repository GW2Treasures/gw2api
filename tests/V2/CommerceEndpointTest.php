<?php

class CommerceEndpointTest extends TestCase {
    public function testCommerceUrl() {
        $endpoint = $this->api()->commerce();

        $this->assertEndpointUrl( 'v2/commerce', $endpoint );
    }

    public function testExchangeCoins() {
        $endpoint = $this->api()->commerce()->exchange();

        $this->assertEndpointUrl( 'v2/commerce/exchange', $endpoint );

        $this->mockResponse( '{"coins_per_gem":2000,"quantity":5}' );
        $this->assertEquals( 5, $endpoint->coins(10000)->quantity );
    }

    public function testExchangeGems() {
        $endpoint = $this->api()->commerce()->exchange();

        $this->assertEndpointUrl( 'v2/commerce/exchange', $endpoint );

        $this->mockResponse( '{"coins_per_gem":1269,"quantity":63489}' );
        $this->assertEquals( 1269, $endpoint->gems(50)->coins_per_gem );
    }

    public function testListings() {
        $endpoint = $this->api()->commerce()->listings();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/commerce/listings', $endpoint );

        $this->mockResponse('{"id":24,"buys":[{"listings":1,"unit_price":110,"quantity":141}]}');
        $this->assertEquals( 110, $endpoint->get(24)->buys[0]->unit_price );
    }

    public function testPrices() {
        $endpoint = $this->api()->commerce()->prices();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/commerce/prices', $endpoint );

        $this->mockResponse('{"id":24,"buys":{"quantity":21362,"unit_price":110},"sells":{"quantity":15145,"unit_price":115}}');
        $this->assertEquals( 15145, $endpoint->get(24)->sells->quantity );
    }
}
