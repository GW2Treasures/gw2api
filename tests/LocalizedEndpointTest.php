<?php

use GW2Treasures\GW2Api\V2\Localization\Exception\InvalidLanguageException;
use Stubs\LocalizedEndpointStub;

class LocalizedEndpointTest extends TestCase {
    protected function getLocalizedEndpoint() {
        return new LocalizedEndpointStub( $this->api() );
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $endpoint = $this->getLocalizedEndpoint();

        $this->assertEndpointIsLocalized( $endpoint );

        $endpoint->lang('en')->test();

        $request = $this->getLastRequest();
        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'lang', $query_array,
            'LocalizedEndpoint sets ?lang query parameter' );
        $this->assertEquals( 'en', $query_array['lang'],
            'LocalizedEndpoint sets correct query parameter value' );
    }

    public function testRepeated() {
        $this->mockResponse('[]', 'de');
        $this->mockResponse('[]', 'de');

        $endpoint_de = $this->getLocalizedEndpoint()->lang('de');

        $this->assertEndpointIsLocalized( $endpoint_de );

        $endpoint_de->test();
        $endpoint_de->test();

        $request = $this->getLastRequest();
        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'lang', $query_array,
            'LocalizedEndpoint sets ?lang query parameter on repeated request' );
        $this->assertEquals( 'de', $query_array['lang'],
            'LocalizedEndpoint sets correct query parameter value pm repeated request' );
    }

    public function testNested() {
        $this->mockResponse('[]', 'fr');

        $this->getLocalizedEndpoint()->lang('es')->lang('fr')->test();

        $request = $this->getLastRequest();
        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'lang', $query_array,
            'LocalizedEndpoint sets ?lang query parameter on nested request' );
        $this->assertEquals( 'fr', $query_array['lang'],
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
