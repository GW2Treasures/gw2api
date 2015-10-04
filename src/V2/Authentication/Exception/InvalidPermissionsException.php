<?php

namespace GW2Treasures\GW2Api\V2\Authentication\Exception;

use Psr\Http\Message\ResponseInterface;

class InvalidPermissionsException extends AuthenticationException {
    /** @var string $missingScope */
    protected $missingScope;

    public function __construct( $message, $missingScope, ResponseInterface $response ) {
        $this->missingScope = $missingScope;

        parent::__construct( $message, $response );
    }

    /**
     * Get the scope that was missing.
     *
     * @return string
     */
    public function getMissingScope() {
        return $this->missingScope;
    }
}
