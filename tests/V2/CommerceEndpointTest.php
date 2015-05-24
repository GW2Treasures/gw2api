<?php

class CommerceEndpointTest extends TestCase {
    public function testExchangeCoins() {
        $this->mockResponse( '{"coins_per_gem":2000,"quantity":5}' );

        $this->assertEquals( 5, $this->api()->commerce()->exchange()->coins(10000)->quantity );
    }

    public function testExchangeGems() {
        $this->mockResponse( '{"coins_per_gem":1269,"quantity":63489}' );

        $this->assertEquals( 1269, $this->api()->commerce()->exchange()->gems(50)->coins_per_gem );
    }

    public function testListings() {
        $this->mockResponse('{"id":24,"buys":[{"listings":1,"unit_price":110,"quantity":141}]}');

        $this->assertEquals( 110, $this->api()->commerce()->listings()->get(24)->buys[0]->unit_price );
    }

    public function testPrices() {
        $this->mockResponse('{"id":24,"buys":{"quantity":21362,"unit_price":110},"sells":{"quantity":15145,"unit_price":115}}');

        $this->assertEquals( 15145, $this->api()->commerce()->prices()->get(24)->sells->quantity );
    }
}
