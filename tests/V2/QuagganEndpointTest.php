<?php

class QuagganEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse('{"id":"cheer","url":"https://static.staticwars.com/quaggans/cheer.jpg"}');

        $this->assertStringEndsWith( 'cheer.jpg', $this->api()->quaggans()->get('cheer')->url );
    }
}
