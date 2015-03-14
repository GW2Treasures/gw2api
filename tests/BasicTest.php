<?php

//TODO: Replace with real tests.
//      These tests are stupid and most can break at any point in the future, they were just here to help me
//      implement the first version of this library.
class BasicTest extends TestCase {
    public function testQuaggans() {
        $quaggans = $this->api()->quaggans()->all();
        $this->assertCount( 35, $quaggans );

        $quagganEndpoint = $this->api()->quaggans();
        $q2 = $quagganEndpoint->many( $quagganEndpoint->ids() );
    }

    public function testWorlds() {
        $anvilRock = $this->api()->worlds()->get(1001);
        $this->assertEquals("Anvil Rock", $anvilRock->name);

        $ambossfels = $this->api()->worlds()->lang('de')->get(1001);
        $this->assertEquals("Ambossfels", $ambossfels->name);
    }

    public function testSkins() {
        $skinIds = $this->api()->skins()->ids();
        $skins = $this->api()->skins()->all();

        $this->assertCount( count( $skinIds ), $skins );
    }

    public function testItems() {
//        $itemIds = $this->api()->items()->ids();
//        $items = $this->api()->items()->all();
//
//        $this->assertCount( count( $itemIds ), $items );
    }

    public function testLocalization() {
        $worlds = $this->api()->worlds();

        $worlds_de = $worlds->lang('de');
        $this->assertEquals( 'Ambossfels', $worlds_de->get(1001)->name,
            'Localized endpoint returns localized response' );
        $this->assertEquals( 'Ambossfels', $worlds_de->get(1001)->name,
            'Repeated usage of localized endpoint keeps language' );

        $worlds_es = $worlds->lang('es');
        $this->assertEquals( 'Roca del Yunque', $worlds_es->get(1001)->name,
            'Endpoint can be localized in different languages' );

        $this->assertEquals( 'Ambossfels', $worlds_de->get(1001)->name,
            'Creating a new localized version of origin endpoint doesn\'t alter existing localizations' );

        $this->assertEquals("Anvil Rock", $worlds->get(1001)->name,
            'Creating localized endpoint doesn\'t alter origin endpoint' );
    }
}
