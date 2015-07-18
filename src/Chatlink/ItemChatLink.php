<?php

namespace GW2Treasures\GW2Api\Chatlink;

use GW2Treasures\GW2Api\Model\ItemStack;

class ItemChatLink extends ChatLink {
    const UPGRADE_TYPE_NONE = 0x00;
    const UPGRADE_TYPE_1_UPGRADE = 0x40;
    const UPGRADE_TYPE_2_UPGRADES = 0x60;
    const UPGRADE_TYPE_SKINNED = 0x80;
    const UPGRADE_TYPE_SKINNED_1_UPGRADE= 0xC0;
    const UPGRADE_TYPE_SKINNED_2_UPGRADES = 0xE0;

    const UPGRADE_HAS_UPGRADE_2 = 0x20;
    const UPGRADE_HAS_UPGRADE_1 = 0x40;
    const UPGRADE_HAS_SKIN = 0x80;

    /** @var ItemStack $itemStack */
    protected $itemStack;

    /**
     * @param ItemStack $itemStack
     */
    public function __construct( ItemStack $itemStack ) {
        $this->itemStack = $itemStack;
    }

    public function getType() {
        return self::TYPE_ITEM;
    }

    /**
     * @return ItemStack
     */
    public function getItemStack() {
        return $this->itemStack;
    }

    /**
     * @param string $code
     * @return ChatLink
     * @throws \Exception
     */
    public static function decode( $code ) {
        $data = self::getData( $code );

        if( $data[0] !== self::TYPE_ITEM ) {
            return Chatlink::decode($code);
        }

        $itemStack = new ItemStack();
        $index = 1;

        $itemStack->count = self::readCount( $data, $index );
        $itemStack->id = self::readItemId( $data, $index );

        $upgradeType = self::readUpgradeType( $data, $index );

        if( ($upgradeType & self::UPGRADE_HAS_SKIN) === self::UPGRADE_HAS_SKIN ) {
            $itemStack->skin = self::readUpgradeItemId( $data, $index );
        }

        if( ($upgradeType & self::UPGRADE_HAS_UPGRADE_1) === self::UPGRADE_HAS_UPGRADE_1 ) {
            $itemStack->upgrades[] = self::readUpgradeItemId($data, $index);
        }

        if( ($upgradeType & self::UPGRADE_HAS_UPGRADE_2) === self::UPGRADE_HAS_UPGRADE_2 ) {
            $itemStack->upgrades[] = self::readUpgradeItemId($data, $index);
        }

        // we should be done now
        if( $index !== count($data) ) {
            throw new \Exception('Unknown data in chat code');
        }

        return new self($itemStack);
    }

    protected static function readCount( $data, &$index ) {
        return $data[$index++];
    }

    protected static function readItemId( $data, &$index ) {
        return $data[$index++] | $data[$index++] << 8 | $data[$index++] << 16;
    }

    protected static function readUpgradeType( $data, &$index ) {
        return $data[$index++];
    }

    protected static function readUpgradeItemId( $data, &$index ) {
        // read id
        $id = self::readItemId( $data, $index );

        // skip next byte (always 0x00)
        $index++;

        return $id;
    }

    public function encode() {
        $data = [ $this->getType() ];

        $itemStack = $this->getItemStack();

        $this->writeItemCount( $data, $itemStack->count );
        $this->writeItemId( $data, $itemStack->id );

        $hasSkin = $itemStack->skin !== null;
        $hasUpgrade1 = count($itemStack->upgrades) >= 1;
        $hasUpgrade2 = count($itemStack->upgrades) >= 2;

        $upgradeFlag = self::UPGRADE_TYPE_NONE;

        if( $hasSkin ) {
            $upgradeFlag |= self::UPGRADE_HAS_SKIN;
        }

        if( $hasUpgrade1 ) {
            $upgradeFlag |= self::UPGRADE_HAS_UPGRADE_1;
        }

        if( $hasUpgrade2 ) {
            $upgradeFlag |= self::UPGRADE_HAS_UPGRADE_2;
        }

        $this->writeUpgradeFlag( $data, $upgradeFlag );

        if( $hasSkin ) {
            $this->writeUpgradeItemId( $data, $itemStack->skin );
        }

        if( $hasUpgrade1 ) {
            $this->writeUpgradeItemId( $data, $itemStack->upgrades[0] );
        }

        if( $hasUpgrade2 ) {
            $this->writeUpgradeItemId( $data, $itemStack->upgrades[1] );
        }

        $chatcode = '';
        foreach( $data as $char ) {
            $chatcode .= chr( $char );
        }
        return '[&'.base64_encode($chatcode).']';
    }

    protected function writeItemCount( &$data, $count ) {
        $data[] = $count;
    }

    protected function writeItemId( &$data, $id ) {
        $data[] = ($id >> 0x00) & 0xFF;
        $data[] = ($id >> 0x08) & 0xFF;
        $data[] = ($id >> 0x10) & 0xFF;
    }

    protected function writeUpgradeFlag( &$data, $upgradeFlag ) {
        $data[] = $upgradeFlag;
    }

    protected function writeUpgradeItemId( &$data, $itemId ) {
        $this->writeItemId( $data, $itemId );
        $data[] = 0x00;
    }
}
