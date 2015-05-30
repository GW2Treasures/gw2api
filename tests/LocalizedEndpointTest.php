<?php

use GW2Treasures\GW2Api\V2\Localization\Exception\InvalidLanguageException;
use Stubs\LocalizedEndpointStub;

class LocalizedEndpointTest extends TestCase {
    protected function getLocalizedEndpoint() {
        return new LocalizedEndpointStub( $this->api() );
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $this->getLocalizedEndpoint()->lang('en')->test();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter' );
        $this->assertEquals( 'en', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value' );
    }

    public function testRepeated() {
        $this->mockResponse('[]', 'de');
        $this->mockResponse('[]', 'de');

        $endpoint_de = $this->getLocalizedEndpoint()->lang('de');

        $endpoint_de->test();
        $endpoint_de->test();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on repeated request' );
        $this->assertEquals( 'de', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value pm repeated request' );
    }

    public function testNested() {
        $this->mockResponse('[]', 'fr');

        $this->getLocalizedEndpoint()->lang('es')->lang('fr')->test();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->getQuery()->hasKey('lang'),
            'LocalizedEndpoint sets ?lang query parameter on nested request' );
        $this->assertEquals( 'fr', $request->getQuery()->get('lang'),
            'LocalizedEndpoint sets correct query parameter value on nested request' );
    }

    public function testInvalidLanguage() {
        $this->mockResponse('[]', 'en');

        try {
            $this->getLocalizedEndpoint()->lang('invalid')->test();
        } catch( InvalidLanguageException $ex ) {
            $this->assertEquals( 'en', $ex->getResponseLanguage() );
            $this->assertEquals( 'invalid', $ex->getRequestLanguage() );

            $this->assertTrue( strstr( $ex->getMessage(), 'Invalid language' ) !== false );

            return;
        }

        $this->fail();
    }
}
