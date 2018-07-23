<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 9:47 PM
 */

namespace SecureMessaging;

use SecureMessaging\SecureTypes;

class Session
{

    private $sessionToken;
    private $messagingApiBaseUrl;
    //private $portalCode;
    //private $baseURL;
    //private $apiBaseURL;

    public function __construct($sessionToken, $messagingApiBaseUrl){
        $this->sessionToken = $sessionToken;
        //$this->portalCode = $portalCode;
        $this->messagingApiBaseUrl = $messagingApiBaseUrl;
        //$this->apiBaseURL = $baseURL . "/" . $portalCode . "/api";
    }

    public function getSessionToken(){
        return $this->sessionToken;
    }

    public function getAPIBaseURL(){
        return $this->messagingApiBaseUrl;
    }
}