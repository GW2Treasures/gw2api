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
}
