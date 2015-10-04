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
        $this->assertHasQuery( $request, 'lang', 'en' );
    }

    public function testRepeated() {
        $this->mockResponse('[]', 'de');
        $this->mockResponse('[]', 'de');

        $endpoint_de = $this->getLocalizedEndpoint()->lang('de');

        $this->assertEndpointIsLocalized( $endpoint_de );

        $endpoint_de->test();
        $endpoint_de->test();

        $request = $this->getLastRequest();

        $this->assertHasQuery( $request, 'lang', 'de' );
    }

    public function testNested() {
        $this->mockResponse('[]', 'fr');

        $this->getLocalizedEndpoint()->lang('es')->lang('fr')->test();

        $request = $this->getLastRequest();

        $this->assertHasQuery( $request, 'lang', 'fr' );
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
