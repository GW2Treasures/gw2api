<?php

use GW2Treasures\GW2Api\GW2Api;
use Stubs\EndpointStub;

const EXPECTED_DEFAULT_SCHEMA = GW2Api::DEFAULT_SCHEMA;
const EXPECTED_CUSTOM_SCHEMA = '2077-01-01T00:00:00Z';

class SchemaTest extends BasicTestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }

    public function testDefaultSchema() {
        $this->mockResponse('[]');

        $endpoint = $this->getEndpoint();

        $this->assertEquals(EXPECTED_DEFAULT_SCHEMA, $endpoint->getSchema());

        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertHasHeader($request, 'X-Schema-Version', EXPECTED_DEFAULT_SCHEMA);
    }

    public function testCustomSchema() {
        $this->mockResponse('[]');

        $endpoint = $this->getEndpoint()->schema(EXPECTED_CUSTOM_SCHEMA);

        $this->assertEquals(EXPECTED_CUSTOM_SCHEMA, $endpoint->getSchema());

        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertHasHeader($request, 'X-Schema-Version', EXPECTED_CUSTOM_SCHEMA);
    }

    public function testGlobalSchema() {
        $this->mockResponse('[]');

        $endpoint = $this->getEndpoint();
        $this->assertEquals(EXPECTED_DEFAULT_SCHEMA, $endpoint->getSchema());

        $this->api()->schema(EXPECTED_CUSTOM_SCHEMA);

        $this->assertEquals(EXPECTED_CUSTOM_SCHEMA, $endpoint->getSchema());

        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertHasHeader($request, 'X-Schema-Version', EXPECTED_CUSTOM_SCHEMA);

        // clean up schema for other tests
        $this->resetApi();
    }
}
