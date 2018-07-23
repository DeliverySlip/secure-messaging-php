<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:04 PM
 */

namespace SecureMessaging;


use GuzzleHttp\Client;
use SecureMessaging\ccc\ServiceCodeResolver;
use SecureMessaging\SecureTypes;
use SecureMessaging\Credentials;


class SecureMessenger
{

    private $messagingApiBaseUrl; // this is a messaging api base url
    private $session;

    public static function resolveViaServiceCode($serviceCode){

        $secureMessagingApiBaseUrl = ServiceCodeResolver::resolve($serviceCode);
        return new SecureMessenger($secureMessagingApiBaseUrl);
    }

    public function __construct($messagingApiBaseURLOrSessionObject){

        if(is_string($messagingApiBaseURLOrSessionObject)){
            $this->messagingApiBaseUrl = $messagingApiBaseURLOrSessionObject;
        }else{
            //it is a session object
            $this->session = $messagingApiBaseURLOrSessionObject;
            $this->messagingApiBaseUrl = $messagingApiBaseURLOrSessionObject->getAPIBaseURL();
        }
    }

    public function login(Credentials $credentials){
        $this->session = SessionFactory::createSession($credentials, $this->messagingApiBaseUrl);
    }


}