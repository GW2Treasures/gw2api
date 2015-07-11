<?php

class GW2ApiTest extends TestCase {
    public function testExtractCacertPhar() {
        $api = new \Stubs\GW2ApiStub(true);

        $this->assertTrue( $api->isIncludedAsPhar(), 'should simulate being included as phar' );

        $path = $api->getCacertFilePath();
        $sourcePath = __DIR__ . '/../src/cacert.pem';

        $this->assertStringStartsWith( sys_get_temp_dir(), $path,
            'file path of cacert should be in temp directory');

        // delete extracted cacert if it exists
        if( file_exists( $path )) {
            unlink( $path );
        }

        $this->assertFileNotExists( $path, 'extracted cacert file should not exist before extracting' );

        $api->extractCacertFile();

        $this->assertFileExists( $path, 'extracted cacert file should exist after extracting' );
        $this->assertFileEquals( $sourcePath, $path, 'extracted cacert file should match source cacert file' );
    }
}
