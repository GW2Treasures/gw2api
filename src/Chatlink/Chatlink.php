<?php

namespace GW2Treasures\GW2Api\Chatlink;

abstract class Chatlink {
    const TYPE_COIN = 0x01;
    const TYPE_ITEM = 0x02;
    const TYPE_TEXT = 0x03;
    const TYPE_MAP = 0x04;
    const TYPE_PVP_GAME = 0x05;
    const TYPE_SKILL = 0x07;
    const TYPE_TRAIT = 0x08;
    const TYPE_PLAYER = 0x09;
    const TYPE_RECIPE = 0x0A;
    const TYPE_WARDROBE = 0x0B;
    const TYPE_OUTFIT = 0x0C;

    /**
     *  Decodes a base64 encoded chat code.
     */
    public static function decode( $code ) {
        $data = self::getData( $code );

        switch( $data[0] ) {
            case self::TYPE_ITEM: return ItemChatLink::decode( $code );
        }

        throw new \Exception('Unknown chat link type');
    }

    public abstract function getType();

    /**
     * Parses base64 encoded chat code and returns byte array.
     *
     * @param string $code
     * @return int[]
     */
    protected static function getData( $code ) {
        $data = [];
        foreach( str_split( base64_decode( $code )) as $char ){
            $data[] = ord( $char );
        }

        return $data;
    }
}
