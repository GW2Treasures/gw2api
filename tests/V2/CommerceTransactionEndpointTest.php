<?php

use GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\ListEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\TypeEndpoint;

class CommerceTransactionEndpointTest extends TestCase {
    public function testCurrentBuys() {
        $this->mockResponse( '[{
            "id": 1999,
            "item_id": 19699,
            "price": 1004,
            "quantity": 20,
            "created": "2014-12-15T14:43:36+00:00"
        }]' );

        $this->assertEquals( 1004,
            $this->api()->commerce()->transactions('api_key')->current()->buys()->page(0, 1)[0]->price );
    }

    public function testCurrentSells() {
        $this->mockResponse( '[{
            "id": 1997,
            "item_id": 19699,
            "price": 1003,
            "quantity": 20,
            "created": "2014-12-15T14:43:35+00:00"
        }]' );

        $this->assertCount( 1,
            $this->api()->commerce()->transactions('api_key')->current()->sells()->page(0, 1));
    }

    public function testHistoryBuys() {
        $this->mockResponse( '[{
            "id": 1000,
            "item_id": 19699,
            "price": 1004,
            "quantity": 20,
            "created": "2014-12-15T14:59:38+00:00",
		    "purchased": "2014-12-15T14:59:39+00:00"
        }]' );

        $this->assertEquals( 20,
            $this->api()->commerce()->transactions('api_key')->history()->buys()->page(0, 1)[0]->quantity );
    }

    public function testHistorySells() {
        $this->mockResponse( '[{
            "id": 999,
            "item_id": 19699,
            "price": 1003,
            "quantity": 20,
            "created": "2014-12-15T14:59:36+00:00",
		    "purchased": "2014-12-15T14:59:37+00:00"
        }]' );

        $this->assertEquals( 19699,
            $this->api()->commerce()->transactions('api_key')->history()->sells()->page(0, 1)[0]->item_id );
    }

    /** @expectedException \InvalidArgumentException */
    public function testTypeEndpointValidation() {
        new TypeEndpoint( $this->api(), 'api_key', 'invalid' );
    }

    /** @expectedException \InvalidArgumentException */
    public function testListEndpointTypeValidation() {
        new ListEndpoint( $this->api(), 'api_key', 'invalid', 'buys' );
    }

    /** @expectedException \InvalidArgumentException */
    public function testListEndpointListValidation() {
        new ListEndpoint( $this->api(), 'api_key', 'current', 'invalid' );
    }
}
