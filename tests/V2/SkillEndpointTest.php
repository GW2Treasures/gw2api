<?php

class SkillEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->skills();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/skills', $endpoint );

        $this->mockResponse('[1175,5487,5489,5490,5491,5492]');
        $this->assertEquals( [1175,5487,5489,5490,5491,5492], $endpoint->ids() );
    }
}
