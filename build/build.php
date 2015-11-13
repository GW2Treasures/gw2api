<?php

// directory paths
$baseDirectory = realpath(__DIR__.'/..');
$buildDirectory = $baseDirectory . '/build';
$artifactsDirectory = $buildDirectory . '/artifacts';
$stagingDirectory = $artifactsDirectory . '/staging';

// create all needed directories.
if( !file_exists( $artifactsDirectory )) {
    mkdir($artifactsDirectory);
}

// setup packager
require $baseDirectory . '/vendor/mtdowling/burgomaster/src/Burgomaster.php';
$packager = new \Burgomaster( $stagingDirectory, $baseDirectory );

// include readme and license files
foreach(['README.md', 'LICENSE'] as $file) {
    $packager->deepCopy( $file, $file );
}

// include source
$packager->recursiveCopy( 'src', 'GW2Treasures/GW2Api', ['php'] );

// include cacert.pem
$packager->deepCopy('src/cacert.pem', 'GW2Treasures/GW2Api/cacert.pem');

// create the autoloader
$packager->createAutoloader();

// build phar and zip archives
$packager->createPhar( $buildDirectory . '/artifacts/gw2api.phar');
$packager->createZip( $buildDirectory . '/artifacts/gw2api.zip');
