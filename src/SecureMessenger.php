<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:04 PM
 */

namespace SecureMessaging;


use GuzzleHttp\Client;
use SecureMessaging\SecureTypes;
use SecureMessaging\Credentials;


class SecureMessenger
{

    private $portalCode;
    private $baseURL;
    private $credentials;
    private $apiBaseURL;

    private $guzzleClient;

    public function __construct(SecureTypes\String $portalCode, SecureTypes\String $baseURL){
        $this->portalCode = $portalCode;
        $this->baseURL = $baseURL;



        $this->guzzleClient = new Client();

    }
}