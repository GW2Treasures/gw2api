<?php

namespace Stubs;

use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class LocalizedEndpointStub extends EndpointStub implements ILocalizedEndpoint {
    use LocalizedEndpoint;
}
