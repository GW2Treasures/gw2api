<?php

namespace GW2Treasures\GW2Api\V2\Localization\Exception;

use GW2Treasures\GW2Api\Exception\ApiException;
use Psr\Http\Message\ResponseInterface;

class InvalidLanguageException extends ApiException {

    /** @var string $requestLanguage */
    protected $requestLanguage;

    /** @var string $responseLanguage */
    protected $responseLanguage;

    /**
     * @param string            $message
     * @param string            $requestLanguage
     * @param string            $responseLanguage
     * @param ResponseInterface $response
     */
    public function __construct( $message, $requestLanguage, $responseLanguage, ResponseInterface $response ) {
        $this->requestLanguage = $requestLanguage;
        $this->responseLanguage = $responseLanguage;

        parent::__construct( $message, $response );
    }

    /**
     * Get the requested language.
     *
     * @return string
     */
    public function getRequestLanguage() {
        return $this->requestLanguage;
    }

    /**
     * Get the language the api responded with.
     *
     * @return string
     */
    public function getResponseLanguage() {
        return $this->responseLanguage;
    }

}
