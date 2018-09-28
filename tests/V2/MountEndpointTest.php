<?php

class MountEndpointTest extends TestCase {
    public function testMounts() {
        $endpoint = $this->api()->mounts();

        $this->assertEndpointUrl( 'v2/mounts', $endpoint );
    }

    public function testMountTypes() {
        $endpoint = $this->api()->mounts()->types();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/mounts/types', $endpoint );

        $this->mockResponse('{"id":"raptor","name":"Raptor","default_skin":1,"skins":[21,24,1,29,81,13,32,99,94,58,35,86,17,88,76,48],"skills":[{"id":40409,"slot":"Weapon_1"}]}');
        $this->assertEquals('Raptor', $endpoint->get('raptor')->name);
    }

    public function testMountSkins() {
        $endpoint = $this->api()->mounts()->skins();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/mounts/skins', $endpoint );

        $this->mockResponse('{"id":1,"name":"Raptor","icon":"https://render.guildwars2.com/file/2F4AAA52F573C5425BFCD7525FB70C9E6DCAD791/1766903.png","mount":"raptor","dye_slots":[{"color_id":19,"material":"leather"}]}');
        $this->assertEquals('Raptor', $endpoint->get(1)->name);
    }
}
