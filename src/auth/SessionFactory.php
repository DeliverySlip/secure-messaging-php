<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 08/01/17
 * Time: 7:05 PM
 */

namespace SecureMessaging\Auth;

use SecureMessaging\Client\HttpRequestHandler;
use SecureMessaging\Utils\BuildVersion;

class SessionFactory
{

    private final function __construct(){}

    public static function createSession(Credentials $credentials, $messagingApiBaseUrl){

        $requestHandler = new HttpRequestHandler($messagingApiBaseUrl);
        $responseHandler = $requestHandler->post("/login",
            $credentials->generateRequestObjectForCredentials());

        if($responseHandler->getStatusCode() == 200){
            $jsonObject = $responseHandler->getJsonBody();

            $responseHandler = $requestHandler->get("/user/settings", [
                "x-sm-session-token" => $jsonObject["sessionToken"],
                "x-sm-client-name" => BuildVersion::getBuildName(),
                "x-sm-client-version" => BuildVersion::getBuildVersion()
            ]);

            return new Session($jsonObject["sessionToken"], $requestHandler->getBaseURL(),
                $responseHandler->getJsonBody()["emailAddress"], $requestHandler);
        }else{
            return null;
        }
    }

    public static function createSessionWithRequestHandler(Credentials $credentials, HttpRequestHandler $requestHandler){

        $responseHandler = $requestHandler->post("/login",
            $credentials->generateRequestObjectForCredentials());

        if($responseHandler->getStatusCode() == 200){
            $jsonObject = $responseHandler->getJsonBody();

            $responseHandler = $requestHandler->get("/user/settings", [
                "x-sm-session-token" => $jsonObject["sessionToken"],
                "x-sm-client-name" => BuildVersion::getBuildName(),
                "x-sm-client-version" => BuildVersion::getBuildVersion()
            ]);

            return new Session($jsonObject["sessionToken"], $requestHandler->getBaseURL(),
                $responseHandler->getJsonBody()["emailAddress"], $requestHandler);
        }else{
            return null;
        }
    }

    /*public static function logout(Session $session){

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

    }*/
}