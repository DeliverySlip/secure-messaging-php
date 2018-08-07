<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:04 PM
 */

namespace SecureMessaging;


use SecureMessaging\Auth\SessionFactory;
use SecureMessaging\ccc\ServiceCodeResolver;
use SecureMessaging\Client\HttpRequestHandler;
use SecureMessaging\Models\Request\MessageOptionsRequest;
use SecureMessaging\Models\Request\PreCreateMessageRequest;
use SecureMessaging\Models\Request\SaveMessageRequest;
use SecureMessaging\Models\Request\SendMessageRequest;
use SecureMessaging\Auth\Credentials;
use SecureMessaging\Utils\BuildVersion;


class SecureMessenger
{

    private $messagingApiBaseUrl; // this is a messaging api base url
    private $session;

    private $httpRequestHandler;

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
            $this->httpRequestHandler = $messagingApiBaseURLOrSessionObject->getRequestHandler();

            $sessionToken = $this->session->getSessionToken();

            $this->httpRequestHandler->setHeaderRequestEventListener(function() use($sessionToken){
                return [
                    "x-sm-client-name" => BuildVersion::getBuildName(),
                    "x-sm-client-version" => BuildVersion::getBuildVersion(),
                    "x-sm-session-token" => $sessionToken
                ];
            });
        }
    }

    public function login(Credentials $credentials){
        $this->session = SessionFactory::createSession($credentials, $this->messagingApiBaseUrl);
        $this->httpRequestHandler = new HttpRequestHandler($this->session->getAPIBaseURL());

        $sessionToken = $this->session->getSessionToken();

        $this->httpRequestHandler->setHeaderRequestEventListener(function() use($sessionToken){
            return [
                "x-sm-client-name" => BuildVersion::getBuildName(),
                "x-sm-client-version" => BuildVersion::getBuildVersion(),
                "x-sm-session-token" => $sessionToken
            ];
        });
    }

    public function preCreateMessage(PreCreateConfiguration $configuration){

        $preCreateMessageRequest = new PreCreateMessageRequest();
        $preCreateMessageRequest->password = $configuration->getPassword();
        $preCreateMessageRequest->parentGuid = $configuration->getParentGuid();
        $preCreateMessageRequest->actionCode = $configuration->getActionCode()->value;

        $httpResponseHandler = $this->httpRequestHandler->post("/v1/messages", $preCreateMessageRequest);

        $responseBody = $httpResponseHandler->getJsonBody();

        $secureMessage = new SecureMessage($responseBody["messageGuid"]);
        $secureMessage->setFrom([$this->session->getEmailAddress()]);

        return $secureMessage;
    }

    public function saveMessage($message){

        if($message instanceof SavedMessage){
            $message = $message->message;
        }

        $saveMessageRequest = new SaveMessageRequest();
        $saveMessageRequest->to = $message->getTo();
        $saveMessageRequest->from = $message->getFrom();
        $saveMessageRequest->cc = $message->getCC();
        $saveMessageRequest->bcc = $message->getBCC();
        $saveMessageRequest->subject = strval($message->getSubject());
        $saveMessageRequest->body = strval($message->getBody());
        $saveMessageRequest->bodyFormat = $message->getBodyFormat()->value;
        $saveMessageRequest->messageGuid = strval($message->getMessageGuid());

        $messageOptions = $message->getMessageOptions();
        $messageOptionsRequest = new MessageOptionsRequest();
        $messageOptionsRequest->shareTracking =  $messageOptions->getShareTracking();
        $messageOptionsRequest->fyeoType = $messageOptions->getFYEOType()->value;
        $messageOptionsRequest->allowTracking = $messageOptions->getAllowTracking();
        $messageOptionsRequest->allowReply = $messageOptions->getAllowReply();
        $messageOptionsRequest->allowForward = $messageOptions->getAllowForward();

        $saveMessageRequest->messageOptions = $messageOptionsRequest;

        $httpResponseHandler = $this->httpRequestHandler->put("/messages/" . strval($message->getMessageGuid()) . "/save", $saveMessageRequest);

        $responseBody = $httpResponseHandler->getJsonBody();

        $savedMessage = new SavedMessage();
        $savedMessage->message = $message;

        return $savedMessage;
    }

    public function sendMessage(SavedMessage $savedMessage){

        $sendMessageRequest = new SendMessageRequest();
        $sendMessageRequest->messageGuid = $savedMessage->message->getMessageGuid();
        $sendMessageRequest->craCode = $savedMessage->message->getCRACode();
        $sendMessageRequest->inviteNewUsers = $savedMessage->message->getInviteNewUsers();
        $sendMessageRequest->sendEmailNotification = $savedMessage->message->getSendNotifications();

        $httpResponseHandler = $this->httpRequestHandler->put("/messages/" .
            strval($savedMessage->message->getMessageGuid()) . "/send", $sendMessageRequest);

    }


}