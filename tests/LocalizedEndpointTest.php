<?php

use Stubs\LocalizedEndpointStub;

class LocalizedEndpointTest extends TestCase {
    protected function getLocalizedEndpoint() {
        return new LocalizedEndpointStub( $this->api() );
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $this->getLocalizedEndpoint()->lang('en')->get();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter' );
        $this->assertEquals( 'en', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value' );
    }

    public function testRepeated() {
        $this->mockResponse('[]');
        $this->mockResponse('[]');

        $endpoint_de = $this->getLocalizedEndpoint()->lang('de');

        $endpoint_de->get();
        $endpoint_de->get();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on repeated request' );
        $this->assertEquals( 'de', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value pm repeated request' );
    }

    public function testNested() {
        $this->mockResponse('[]');

        $this->getLocalizedEndpoint()->lang('es')->lang('fr')->get();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on nested request' );
        $this->assertEquals( 'fr', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value on nested request' );
    }
}
