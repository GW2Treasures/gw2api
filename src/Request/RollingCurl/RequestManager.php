<?php

namespace GW2Treasures\GW2Api\Request\RollingCurl;

use GW2Treasures\GW2Api\Request\RequestManager as AbstractRequestManager;
use RollingCurl\Request;
use RollingCurl\RollingCurl;

class RequestManager extends AbstractRequestManager {

    /**
     * @param string   $url
     * @param string[] $query
     * @param array    $header
     * @return Response
     */
    public function request( $url, array $query = [], array $header = [] ) {
        return $this->requestMany( $url, [ $query ], $header )[0];
    }

    /**
     * @param string     $url
     * @param string[][] $queries
     * @param array      $header
     * @return Response[]
     * @throws \Exception
     */
    public function requestMany( $url, array $queries, array $header = [] ) {
        $curl = $this->getCurl();

        // build curl header array from associative array
        $header = array_map( function( $v, $k ) {
            return $k . ': ' . $v;
        }, $header, array_keys($header) );

        $responses = [];

        //echo '[GET] --- start ---' . PHP_EOL;
        //$start = -microtime(true);

        foreach( $queries as $query ) {
            $queryUrl = $url;
            if( count( $query ) > 0 ) {
                $queryUrl .= '?' . http_build_query( $query );
            }
            //echo '[GET] ' . $queryUrl . PHP_EOL;
            $curl->get( $this->baseUrl . $queryUrl, null, [ CURLOPT_HTTPHEADER => $header ] );
        }

        $curl->setCallback( function( Request $request ) use ( &$responses ) {
            $responses[] = new Response( $request );
        });

        $curl->execute();
        //echo '[GET] --- end: ' . ( ($start + microtime( true )) * 1000 ) . 'ms ---' . PHP_EOL;

        return $responses;
    }

    protected function getCurl() {
        $curl = new RollingCurl();
        $curl->addOptions([
            CURLOPT_CAINFO => $this->getCertPath(),
            CURLOPT_HEADER => true,
            CURLOPT_FAILONERROR => false,
//            CURLOPT_USERAGENT => 'GW2Treasures Bot/1.0 (+https://gw2treasures.com/contact)'
        ]);
        return $curl;
    }

}
