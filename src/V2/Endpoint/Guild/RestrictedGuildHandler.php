<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild;

use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\GuildLeaderRequiredException;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\MembershipRequiredException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @method IRestrictedGuildEndpoint getEndpoint()
 */
class RestrictedGuildHandler extends ApiHandler {
    public function __construct(IRestrictedGuildEndpoint $endpoint) {
        parent::__construct($endpoint);
    }

    /**
     * Handle errors by the api.
     *
     * @param ResponseInterface $response
     * @param RequestInterface $request
     *
     * @throws GuildLeaderRequiredException
     * @throws MembershipRequiredException
     */
    public function onError(ResponseInterface $response, RequestInterface $request) {
        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( $json->text === 'access restricted to guild leaders' ) {
                throw new GuildLeaderRequiredException( $json->text, $response );
            } elseif( $json->text === 'membership required' ) {
                throw new MembershipRequiredException( $json->text, $response );
            }
        }
    }
}
