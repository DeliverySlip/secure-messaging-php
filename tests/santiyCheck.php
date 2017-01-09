<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:45 PM
 */

require_once __DIR__ . "/../vendor/autoload.php";

use SecureMessaging\SecureMessenger;
use SecureMessaging\Credentials;
use SecureMessaging\SecureTypes;

$ini_array = parse_ini_file(__DIR__ . "/config.ini");
var_dump($ini_array);

$username = new SecureMessaging\SecureTypes\String($ini_array["username"]);
$password = new SecureTypes\String($ini_array["password"]);

$credentials = new Credentials($username,$password);

//$messenger = new SecureMessenger(new SecureTypes\String("open"), new SecureTypes\String("https://us1.secure-messaging.com"));
//$messenger->login($credentials);

$session = \SecureMessaging\SessionFactory::login($credentials, new SecureTypes\String("https://us1.secure-messaging.com"),new SecureTypes\String("open"));
if($session != null){
    print("Successfully Created Session!\n");
    $secureMessage = \SecureMessaging\SecureMessageFactory::createNewMessage($session);

    var_dump($secureMessage);
}else{
    print("Failed To Create Session!\n");
    var_dump($session);
}

