<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/19/2018
 * Time: 4:38 PM
 */


use SecureMessaging\Credentials;
use SecureMessaging\SecureTypes;
use SecureMessaging\SecureMessenger;
use SecureMessaging\CCC\ServiceCodeResolver;
use SecureMessaging\Lib\GuzzleClientSingleton;

class ServiceCodeTest extends PHPUnit_Framework_TestCase
{

    public static $credentials;
    public static $baseURL;
    public static $portalCode;

    public static function setUpBeforeClass(){
        try{
            GuzzleClientSingleton::disableCertificateVerification();
            $ini_array = parse_ini_file(__DIR__ . "/config.ini");

            $username = $ini_array["username"];
            $password = $ini_array["password"];

            self::$portalCode = $ini_array["servicecode"];
            self::$credentials = new SecureMessaging\Credentials(["username" => $username, "password" => $password]);

            if(array_key_exists("baseURL", $ini_array)){
                self::$baseURL = $ini_array["baseURL"];
                ServiceCodeResolver::setResolverUrl(self::$baseURL);
            }
        }catch(Throwable $e){
            throw new Exception($e);
        }

    }

    public static function testServiceCodeResolver(){
        print(self::$portalCode . "\n");
        $url = ServiceCodeResolver::resolve(self::$portalCode);
        print("Returned URL: " . $url . "\n");
    }



}