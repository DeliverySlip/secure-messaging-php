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
    private $portalCode;
    private $baseURL;
    private $apiBaseURL;

    public function __construct(SecureTypes\String $sessionToken, SecureTypes\String $portalCode, SecureTypes\String $baseURL){
        $this->sessionToken = $sessionToken;
        $this->portalCode = $portalCode;
        $this->baseURL = $baseURL;
        $this->apiBaseURL = $baseURL . "/" . $portalCode . "/api";
    }

    public function getSessionToken(){
        return $this->sessionToken;
    }

    public function getAPIBaseURL(){
        return $this->apiBaseURL;
    }
}