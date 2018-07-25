<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 9:47 PM
 */

namespace SecureMessaging\Auth;

class Session
{

    private $sessionToken;
    private $messagingApiBaseUrl;
    private $emailAddress;
    //private $portalCode;
    //private $baseURL;
    //private $apiBaseURL;

    public function __construct($sessionToken, $messagingApiBaseUrl, $emailAddress){
        $this->sessionToken = $sessionToken;
        //$this->portalCode = $portalCode;
        $this->messagingApiBaseUrl = $messagingApiBaseUrl;
        //$this->apiBaseURL = $baseURL . "/" . $portalCode . "/api";

        $this->emailAddress = $emailAddress;
    }

    public function getSessionToken(){
        return $this->sessionToken;
    }

    public function getAPIBaseURL(){
        return $this->messagingApiBaseUrl;
    }

    public function getEmailAddress(){
        return $this->emailAddress;
    }
}