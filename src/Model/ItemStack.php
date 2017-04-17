<?php

namespace GW2Treasures\GW2Api\Model;

class ItemStack extends \stdClass {
    /** @var int $count */
    public $count = 1;

    /** @var int $id */
    public $id = 0;

    /** @var int[] $upgrades */
    public $upgrades = [];

    /** @var int */
    public $skin = null;

    public static function fromObject( \stdClass $object ) {
        $itemStack = new ItemStack();

        foreach( $object as $property => &$value ) {
            $itemStack->{$property} = $value;
        }

        return $itemStack;
    }

    public static function fromArray( array $array ) {
        $itemStack = new ItemStack();

        foreach( $array as $property => &$value ) {
            $itemStack->{$property} = $value;
        }

        return $itemStack;
    }
}
