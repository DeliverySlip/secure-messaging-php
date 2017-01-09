<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 10:32 PM
 */

namespace SecureMessaging;

//TODO: generate a secure message, execute the appropriate precreate message process here before returning the secure message
use GuzzleHttp\Client;
use SecureMessaging\Lib\ActionTypeEnum;
use SecureMessaging\SecureTypes;

class SecureMessageFactory
{

    public static function createNewMessage(Session $session){
        //$secureMessage = new SecureMessage(new ActionType(ActionTypeEnum::NEW));

        $requestBody = new \stdClass();
        $requestBody->actionCode = "" . ActionTypeEnum::ACTIONTYPE_NEW;

        $guzzleClient = new Client();

        $response = $guzzleClient->request("POST", $session->getAPIBaseURL() . "/v1/messages", [
            "headers" => [
                "x-sm-client-name" => "secure-messaging-php",
                "x-sm-session-token" => $session->getSessionToken()->toString()
            ],
            "json" => (Array)$requestBody
        ]);

        if($response->getStatusCode() == 200){

            $jsonResponse = $response->getBody()->getContents();
            $jsonObject = json_decode($jsonResponse);

            $secureMessage = new SecureMessage(new SecureTypes\String($jsonObject->messageGuid));
            return $secureMessage;

        }else{
            return null;
        }

    }

    public static function createReplyToMessage(Session $session, SecureMessage $message){
        throw new \BadMethodCallException("SecureMessageFactory - createReplyToMessage - Method Not Implemented");
    }

    public static function createReplyAllToMessage(Session $session, SecureMessage $message){
        throw new \BadMethodCallException("SecureMessageFactory - createReplyAllToMessage - Method Not Implemented");
    }



}