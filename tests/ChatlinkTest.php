<?php

use GW2Treasures\GW2Api\Chatlink\Chatlink;
use GW2Treasures\GW2Api\Chatlink\ItemChatLink;
use GW2Treasures\GW2Api\Model\ItemStack;

class ChatlinkTest extends TestCase {
    public function testItemChatLinkDecodeSimple() {
        /** @var ItemChatLink $chatlink */
        $chatlink = Chatlink::decode( '[&AgEJTQAA]' );

        $this->assertEquals( Chatlink::TYPE_ITEM, $chatlink->getType() );
        $this->assertInstanceOf( 'GW2Treasures\GW2Api\Chatlink\ItemChatLink', $chatlink );

        $itemStack = $chatlink->getItemStack();

        $this->assertInstanceOf( 'GW2Treasures\GW2Api\Model\ItemStack', $itemStack );

        $this->assertEquals( 1, $itemStack->count );
        $this->assertEquals( 19721, $itemStack->id );
    }

    public function testItemChatLinkDecodeUpgrades() {
        /** @var ItemChatLink $chatlink */
        $chatlink = Chatlink::decode( '[&AgGqtgDgfQ4AAP9fAAAnYAAA]' );

        $this->assertEquals( Chatlink::TYPE_ITEM, $chatlink->getType() );
        $this->assertInstanceOf( 'GW2Treasures\GW2Api\Chatlink\ItemChatLink', $chatlink );

        $itemStack = $chatlink->getItemStack();

        $this->assertInstanceOf( 'GW2Treasures\GW2Api\Model\ItemStack', $itemStack );

        $this->assertEquals( 1, $itemStack->count );
        $this->assertEquals( 46762, $itemStack->id );
        $this->assertEquals( 3709, $itemStack->skin );
        $this->assertEquals( [24575, 24615], $itemStack->upgrades );
    }

    public function testItemChatLinkEncodeSimple() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 19721
        ]);

        $chatlink = new ItemChatLink( $itemStack );

        $this->assertEquals( 19721, $chatlink->getItemStack()->id );

        $chatcode = $chatlink->encode();

        $this->assertEquals( '[&AgEJTQAA]', $chatcode );
    }


    public function testItemChatLinkEncodeUpgrades() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 46762,
            'skin' => 3709,
            'upgrades' => [24575, 24615]
        ]);

        $chatlink = new ItemChatLink( $itemStack );

        $chatcode = $chatlink->encode();
        $this->assertEquals( '[&AgGqtgDgfQ4AAP9fAAAnYAAA]', $chatcode );
    }
}
