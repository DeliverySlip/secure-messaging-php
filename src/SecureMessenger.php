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

        $this->apiBaseURL = $baseURL . "/" . $portalCode . "/api";

        $this->guzzleClient = new Client();

    }

    public function login(Credentials $credentials){
        $this->credentials = $credentials;

        $response = $this->guzzleClient->request("POST", $this->apiBaseURL . "/login",[
            'json' => (Array)$credentials->generateJSONObject()
        ]);

        if($response->getStatusCode() == 200){
            $jsonResponse = $response->getBody()->getContents();
            $jsonObject = json_decode($jsonResponse);

            return new Session(new SecureTypes\String($jsonObject->sessionToken));
        }else{
            return null;
        }
    }


}