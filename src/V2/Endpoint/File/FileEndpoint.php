<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\File;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\BulkEndpoint;

class FileEndpoint extends Endpoint {
    use BulkEndpoint;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/files';
    }
}
