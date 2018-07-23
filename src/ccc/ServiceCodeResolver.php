<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/19/2018
 * Time: 4:22 PM
 */

namespace SecureMessaging\ccc;


use SecureMessaging\Lib\GuzzleClientSingleton;
use SecureMessaging\Lib\HttpRequestHandler;
use SecureMessaging\Utils\Endpoints;

class ServiceCodeResolver
{

    private static $resolveRoute = "/public/services/single";
    private static $cccBaseURL = null;

    public static function resolve($serviceCode){

        if(self::$cccBaseURL == null){
            self::$cccBaseURL = Endpoints::$CCCAPI;
        }

        $requestHandler=  new HttpRequestHandler(ServiceCodeResolver::$cccBaseURL);
        $responseHandler = $requestHandler->get(ServiceCodeResolver::$resolveRoute . "?serviceCode=" . $serviceCode);

        return $responseHandler->getJsonBody()["urls"]["SecMsgAPI"];
    }

    public static function setResolverUrl($resolverURL){
        ServiceCodeResolver::$cccBaseURL = $resolverURL;
    }

}