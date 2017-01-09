<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 08/01/17
 * Time: 7:05 PM
 */

namespace SecureMessaging;

use SecureMessaging\SecureTypes;
use GuzzleHttp\Client;

class SessionFactory
{

    private final function __construct(){}

    public static function login(Credentials $credentials, SecureTypes\String $baseURL, SecureTypes\String $portalCode){
        $guzzleClient = new Client();
        $apiBaseURL = $baseURL . "/" . $portalCode . "/api";

        $response = $guzzleClient->request("POST", $apiBaseURL . "/login",[
            'json' => (Array)$credentials->generateJSONObject()
        ]);


        if($response->getStatusCode() == 200){
            $jsonResponse = $response->getBody()->getContents();
            $jsonObject = json_decode($jsonResponse);

            unset($guzzleClient);
            return new Session(new SecureTypes\String($jsonObject->sessionToken), $portalCode, $baseURL);
        }else{
            unset($guzzleClient);
            return null;
        }
    }

    public static function logout(Session $session){

        $guzzleClient = new Client();

        $response = $guzzleClient->request("POST", $session->getAPIBaseURL() . "/logout", [
            "exceptions" => false,
            "headers" => [
                "x-sm-session-token" => $session->getSessionToken()->toString()
            ]
        ]);

        if($response->getStatusCode() == 200) {
            return new SecureTypes\Boolean(true);
        }else{
            return new SecureTypes\Boolean(false);
        }

    }
}