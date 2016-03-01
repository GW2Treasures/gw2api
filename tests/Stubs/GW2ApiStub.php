<?php

namespace Stubs;

use GW2Treasures\GW2Api\GW2Api;

class GW2ApiStub extends GW2Api {
    /** @var bool */
    private $isIncludedInPhar;

    function __construct($isIncludedInPhar = false, array $options = []) {
        $this->isIncludedInPhar = $isIncludedInPhar;

        parent::__construct($options);
    }

    /**
     * Checks if the library is included as phar file.
     *
     * @return bool
     */
    public function isIncludedAsPhar() {
        return $this->isIncludedInPhar;
    }

    /**
     * Returns the path to cacert.pem.
     *
     * @return string
     */
    public function getCacertFilePath() {
        return parent::getCacertFilePath();
    }

    /**
     * Copies the phar cacert from the phar into the temp directory.
     */
    public function extractCacertFile() {
        parent::extractCacertFile();
    }

    public function getRealOptions() {
        return $this->options;
    }
}
