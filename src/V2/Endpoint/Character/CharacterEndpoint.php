<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Character;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class CharacterEndpoint extends Endpoint implements IAuthenticatedEndpoint, IBulkEndpoint {
    use BulkEndpoint, AuthenticatedEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/characters';
    }

    /**
     * Get the backstory of a character.
     *
     * @param string $character
     * @return BackstoryEndpoint
     */
    public function backstoryOf( $character ) {
        return new BackstoryEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the core information of a character.
     *
     * @param string $character
     * @return CoreEndpoint
     */
    public function coreOf( $character ) {
        return new CoreEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the crafting information of a character.
     *
     * @param string $character
     * @return CraftingEndpoint
     */
    public function craftingOf( $character ) {
        return new CraftingEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the equipment of a character.
     *
     * @param string $character
     * @return EquipmentEndpoint
     */
    public function equipmentOf( $character ) {
        return new EquipmentEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the herpoints of a character.
     *
     * @param string $character
     * @return HeropointEndpoint
     */
    public function heropointsOf( $character ) {
        return new HeropointEndpoint( $this->api, $this->apiKey, $character );
    }


    /**
     * Get the inventory of a character.
     *
     * @param string $character
     * @return InventoryEndpoint
     */
    public function inventoryOf( $character ) {
        return new InventoryEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get unlocked recipes of a character.
     *
     * @param $character
     * @return RecipeEndpoint
     */
    public function recipesOf( $character ) {
        return new RecipeEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get Super Adventure Box progression of a character.
     *
     * @param $character
     * @return SabEndpoint
     */
    public function sabOf( $character ) {
        return new SabEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the skills of a character.
     *
     * @param string $character
     * @return SkillEndpoint
     */
    public function skillsOf( $character ) {
        return new SkillEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the specializations of a character.
     *
     * @param string $character
     * @return SpecializationEndpoint
     */
    public function specializationsOf( $character ) {
        return new SpecializationEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the training information of a character.
     *
     * @param string $character
     * @return TrainingEndpoint
     */
    public function trainingOf( $character ) {
        return new TrainingEndpoint( $this->api, $this->apiKey, $character );
    }
}
