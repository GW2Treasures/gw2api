<?php

class ContinentEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->continents();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents', $endpoint );

        $this->mockResponse('[1,2]');
        $this->assertEquals( [1,2], $endpoint->ids() );
    }

    public function testFloor() {
        $endpoint = $this->api()->continents()->floorsOf(1);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors', $endpoint );

        $this->mockResponse('{"texture_dims":[32768,32768],"clamped_view":[[1662,2816],[12544,8062]],"regions":{},"id":42}');
        $this->assertEquals( [32768,32768], $endpoint->get(42)->texture_dims );
    }

    public function testRegion() {
        $endpoint = $this->api()->continents()->floorsOf(1)->regionsOf(1);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors/1/regions', $endpoint );

        $this->mockResponse('{"name":"Shiverpeak Mountains","label_coord":[1662,2816],"maps":{},"id":42}');
        $this->assertEquals( [1662,2816], $endpoint->get(42)->label_coord );
    }

    public function testMap() {
        $endpoint = $this->api()->continents()->floorsOf(1)->regionsOf(1)->mapsOf(1);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors/1/regions/1/maps', $endpoint );

        $this->mockResponse('{"name":"","min_level":40,"max_level":50,"default_floor":1,"map_rect":[[-27648,-36864],[27648,39936]],"points_of_interest":{},"id":26}');
        $this->assertEquals( [[-27648,-36864],[27648,39936]], $endpoint->get(26)->map_rect );
    }

    public function testPoi() {
        $endpoint = $this->api()->continents()->floorsOf(1)->regionsOf(1)->mapsOf(1)->poisOf(26);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors/1/regions/1/maps/26/pois', $endpoint );

        $this->mockResponse('{"name":"Leaning Grade","type":"landmark","coord":[19889.7,16594.8],"id":554,"chat_link":"[&BCoCAAA=]"}');
        $this->assertEquals( "Leaning Grade", $endpoint->get(554)->name );
    }

    public function testTask() {
        $endpoint = $this->api()->continents()->floorsOf(1)->regionsOf(1)->mapsOf(1)->tasksOf(26);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors/1/regions/1/maps/26/tasks', $endpoint );

        $this->mockResponse('{"objective":"Assist Daphne","level":40,"coord":[19889.7,16594.8],"id":1,"chat_link":"[&BAEAAAA=]"}');
        $this->assertEquals( 40, $endpoint->get(1)->level );
    }

    public function testSector() {
        $endpoint = $this->api()->continents()->floorsOf(1)->regionsOf(1)->mapsOf(1)->sectorsOf(26);

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/continents/1/floors/1/regions/1/maps/26/sectors', $endpoint );

        $this->mockResponse('{"name":"Tribulation Rift","level":50,"coord":[19889.7,16594.8],"id":513,"chat_link":"[&BAECAAA=]"}');
        $this->assertEquals( "[&BAECAAA=]", $endpoint->get(513)->chat_link );
    }
}
