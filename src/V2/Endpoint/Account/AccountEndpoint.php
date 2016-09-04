<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class AccountEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/account';
    }

    /**
     * Get your basic account info.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }

    /**
     * Get account achievement progression.
     *
     * @return AchievementEndpoint
     */
    public function achievements() {
        return new AchievementEndpoint( $this->parent );
    }

    /**
     * Get the account bank.
     *
     * @return BankEndpoint
     */
    public function bank() {
        return new BankEndpoint( $this->parent );
    }

    /**
     * Get a list of all unlocked dyes (ids).
     *
     * @return DyeEndpoint
     */
    public function dyes() {
        return new DyeEndpoint( $this->parent );
    }

    /**
     * Get a list of item stacks representing the account's shared inventory slots.
     *
     * @return InventoryEndpoint
     */
    public function inventory() {
        return new InventoryEndpoint( $this->parent );
    }

    /**
     * Get the account material storage.
     *
     * @return MaterialEndpoint
     */
    public function materials() {
        return new MaterialEndpoint( $this->parent );
    }

    /**
     * Get unlocked minis.
     *
     * @return MiniEndpoint
     */
    public function minis() {
        return new MiniEndpoint( $this->parent );
    }

    /**
     * Get the unlocked skins.
     *
     * @return SkinEndpoint
     */
    public function skins() {
        return new SkinEndpoint( $this->parent );
    }

    /**
     * Get the account wallet.
     *
     * @return WalletEndpoint
     */
    public function wallet()  {
        return new WalletEndpoint( $this->parent );
    }
}
