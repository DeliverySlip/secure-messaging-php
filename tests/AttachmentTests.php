<?php

use SecureMessaging\Auth\Credentials;
use SecureMessaging\Auth\SessionFactory;
use SecureMessaging\ccc\ServiceCodeResolver;
use SecureMessaging\Client\GuzzleClientSingleton;
use SecureMessaging\Attachment\AttachmentManager;
use SecureMessaging\Client\HttpRequestHandler;
use SecureMessaging\Enums\BodyFormatEnum;
use SecureMessaging\SecureMessageFactory;
use SecureMessaging\SecureMessenger;
use SecureMessaging\Types\BodyFormatType;

/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 8/7/2018
 * Time: 1:39 PM
 */

class AttachmentTests extends PHPUnit_Framework_TestCase
{
    public static $credentials;
    public static $baseURL;
    public static $portalCode;
    public static $recipientEmail;

    public static $password;

    public static function setUpBeforeClass(){
        try{
            GuzzleClientSingleton::disableCertificateVerification();
            $ini_array = parse_ini_file(__DIR__ . "/config.ini");

            $username = $ini_array["username"];
            $password = $ini_array["password"];

            self::$password = $password;

            self::$recipientEmail = $ini_array["recipient"];
            self::$portalCode = $ini_array["servicecode"];
            self::$credentials = new Credentials(["username" => $username, "password" => $password]);

            if(array_key_exists("baseURL", $ini_array)){
                self::$baseURL = $ini_array["baseURL"];
                ServiceCodeResolver::setResolverUrl(self::$baseURL);
            }
        }catch(Throwable $e){
            throw new Exception($e);
        }
    }

    public static function testSendBasicAttachment(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);
        $httpRequestHandler = new HttpRequestHandler($secureMessagingApiBaseURL);
        $session = SessionFactory::createSessionWithRequestHandler(self::$credentials, $httpRequestHandler);

        $messenger = new SecureMessenger($session);
        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);

        $attachmentManager = AttachmentManager::instantiateWithSavedMessage($savedMessage, $httpRequestHandler);

        $fp = fopen("./resources/yellow.jpg", "r");
        //NOTE: Don't close this file pointer until all uploads have completed.
        // Call closeAllFilePointersToAttachments() at the end

        $attachmentManager->addAttachmentFile($fp, "yellow.jpg");
        $attachmentManager->preCreateAllAttachments();
        $attachmentManager->uploadAllAttachments();

        $savedMessage = $messenger->saveMessage($savedMessage);
        $messenger->sendMessage($savedMessage);

        //good for cleanup
        $attachmentManager->closeAllFilePointersToAttachments();
    }

    public static function testDeleteBeforePreCreateAttachment(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);
        $httpRequestHandler = new HttpRequestHandler($secureMessagingApiBaseURL);
        $session = SessionFactory::createSessionWithRequestHandler(self::$credentials, $httpRequestHandler);

        $messenger = new SecureMessenger($session);
        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);

        $attachmentManager = AttachmentManager::instantiateWithSavedMessage($savedMessage, $httpRequestHandler);

        $fp = fopen("./resources/yellow.jpg", "r");

        self::assertTrue($attachmentManager->addAttachmentFile($fp, "yellow.jpg"));
        self::assertTrue($attachmentManager->deleteAttachmentFile($fp));
    }

    public static function testDeleteBeforeUploadAttachment(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);
        $httpRequestHandler = new HttpRequestHandler($secureMessagingApiBaseURL);
        $session = SessionFactory::createSessionWithRequestHandler(self::$credentials, $httpRequestHandler);

        $messenger = new SecureMessenger($session);
        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);

        $attachmentManager = AttachmentManager::instantiateWithSavedMessage($savedMessage, $httpRequestHandler);

        $fp = fopen("./resources/yellow.jpg", "r");

        self::assertTrue($attachmentManager->addAttachmentFile($fp, "yellow.jpg"));
        $attachmentManager->preCreateAllAttachments();
        self::assertTrue($attachmentManager->deleteAttachmentFile($fp));
    }

    public static function testDeleteAfterUploadAttachment(){

        $secureMessagingApiBaseURL = ServiceCodeResolver::resolve(self::$portalCode);
        $httpRequestHandler = new HttpRequestHandler($secureMessagingApiBaseURL);
        $session = SessionFactory::createSessionWithRequestHandler(self::$credentials, $httpRequestHandler);

        $messenger = new SecureMessenger($session);
        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);

        $attachmentManager = AttachmentManager::instantiateWithSavedMessage($savedMessage, $httpRequestHandler);

        $fp = fopen("./resources/yellow.jpg", "r");

        self::assertTrue($attachmentManager->addAttachmentFile($fp, "yellow.jpg"));
        $attachmentManager->preCreateAllAttachments();
        $attachmentManager->uploadAllAttachments();
        self::assertTrue($attachmentManager->deleteAttachmentFile($fp));
    }



}