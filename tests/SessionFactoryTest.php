<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 08/01/17
 * Time: 8:52 PM
 */


use SecureMessaging\SecureTypes;


class SessionFactoryTest extends PHPUnit_Framework_TestCase
{
    public static $credentials;
    public static $baseURL;
    public static $portalCode;

    public static function setUpBeforeClass(){
        $ini_array = parse_ini_file(__DIR__ . "/config.ini");

        $username = new SecureMessaging\SecureTypes\String($ini_array["username"]);
        $password = new SecureTypes\String($ini_array["password"]);

        self::$portalCode = new SecureTypes\String($ini_array["portalCode"]);
        self::$baseURL = new SecureTypes\String($ini_array["baseURL"]);

        self::$credentials = new SecureMessaging\Credentials($username, $password);
    }

    public function testLogin(){

        $session = SecureMessaging\SessionFactory::login(self::$credentials, self::$baseURL, self::$portalCode);
        $this->assertNotNull($session);
    }

    public function testLoginLogout(){

        $session = SecureMessaging\SessionFactory::login(self::$credentials, self::$baseURL, self::$portalCode);
        $this->assertNotNull($session);
        $boolean = \SecureMessaging\SessionFactory::logout($session);

        $this->assertTrue($boolean->value);
    }

    public function testLogoutWithoutLogin(){
        $session = SecureMessaging\SessionFactory::login(self::$credentials, self::$baseURL, self::$portalCode);
        $this->assertNotNull($session);
        $boolean = \SecureMessaging\SessionFactory::logout($session);
        $this->assertTrue($boolean->value);


        $boolean = \SecureMessaging\SessionFactory::logout($session);
        $this->assertFalse($boolean->value);


    }
}
