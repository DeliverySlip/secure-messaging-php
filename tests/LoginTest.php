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
use SecureMessaging\Lib\HttpRequestHandler;
use SecureMessaging\SessionFactory;

class LoginTest extends PHPUnit_Framework_TestCase
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

    public function testBasicLogin(){

        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);
    }

    public function testURLLogin(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);

        $messenger = new SecureMessenger($secureMessagingApiBaseURL);
        $messenger->login(self::$credentials);

    }

    public function testDecoupledLogin(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);

        $httpRequestHandler = new HttpRequestHandler($secureMessagingApiBaseURL);
        $session = SessionFactory::createSessionWithRequestHandler(self::$credentials, $httpRequestHandler);

        $messenger = new SecureMessenger($session);

        //you are logged in at this point
    }

    public function testDecoupledLogin2(){
        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);
        $session = SessionFactory::createSession(self::$credentials, $secureMessagingApiBaseURL);

        $messenger = new SecureMessenger($session);
    }

}