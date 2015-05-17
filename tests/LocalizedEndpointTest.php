<?php

class LocalizedEndpointTest extends TestCase {
    public function testBasic() {
        $this->mockResponse('[]');

        $this->api()->worlds()->lang('en')->all();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter.' );
        $this->assertEquals( 'en', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value' );
    }

    public function testRepeated() {
        $this->mockResponse('[]');
        $this->mockResponse('[]');

        $worlds_en = $this->api()->worlds()->lang('de');

        $worlds_en->all();
        $worlds_en->all();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on repeated request.' );
        $this->assertEquals( 'de', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value pm repeated request.' );
    }

    public function testNested() {
        $this->mockResponse('[]');

        $this->api()->worlds()->lang('es')->lang('fr')->all();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on nested request.' );
        $this->assertEquals( 'fr', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value on nested request' );
    }

    public function testPersistence() {
        $this->mockResponse('[]');
        $this->mockResponse('[]');

        $en = $this->api()->worlds()->lang('en');
        $de = $this->api()->worlds()->lang('de');

        // send first request
        $en->all();
        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on nested request.' );
        $this->assertEquals( 'en', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value on nested request' );

        // send second request
        $de->all();
        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on nested request.' );
        $this->assertEquals( 'de', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value on nested request' );
    }
}
