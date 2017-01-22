<?php

class RecipeEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->recipes();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/recipes', $endpoint );

        $this->mockResponse( '[1,2,3,4,5,6,7,8,9,10]' );
        $this->assertEquals( [1,2,3,4,5,6,7,8,9,10], $endpoint->ids() );
    }

    public function testSearchInput() {
        $endpoint = $this->api()->recipes()->search();

        $this->assertEndpointUrl( 'v2/recipes/search', $endpoint );

        $this->mockResponse( '[7259,7260,7261,7262,7263,7264,7265,7266,7267,7268,7269,7270,7271,7272,7273,7274,7275]' );
        $this->assertContains( 7267, $endpoint->input(43775) );
        $this->assertEquals('input=43775', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testSearchOutput() {
        $endpoint = $this->api()->recipes()->search();

        $this->assertEndpointUrl( 'v2/recipes/search', $endpoint );

        $this->mockResponse( '[7237]' );
        $this->assertEquals( [7237], $endpoint->output(43775) );
        $this->assertEquals('output=43775', $this->getLastRequest()->getUri()->getQuery());
    }
}
