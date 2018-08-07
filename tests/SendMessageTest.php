<?php

use SecureMessaging\Auth\Credentials;
use SecureMessaging\ccc\ServiceCodeResolver;
use SecureMessaging\Client\GuzzleClientSingleton;
use SecureMessaging\SecureMessenger;
use SecureMessaging\PreCreateConfiguration;
use SecureMessaging\Enums\ActionTypeEnum;
use SecureMessaging\Types\ActionType;
use SecureMessaging\Types\BodyFormatType;
use SecureMessaging\Enums\BodyFormatEnum;
use SecureMessaging\SecureMessageFactory;
use SecureMessaging\SecureMessageOptions;
use SecureMessaging\Types\FyeoType;
use SecureMessaging\Enums\FyeoTypeEnum;


/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 12:46 PM
 */

class SendMessageTest extends PHPUnit_Framework_TestCase
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

    public function testSendBasicMessage(){

        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);

        $preCreateConfiguration = new PreCreateConfiguration();
        $preCreateConfiguration->setActionCode(new ActionType(ActionTypeEnum::ACTIONTYPE_NEW));

        $secureMessage = $messenger->preCreateMessage($preCreateConfiguration);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);
        $messenger->sendMessage($savedMessage);

    }

    public function testSendBasicMessageWithFactory(){

        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);

        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $savedMessage = $messenger->saveMessage($secureMessage);
        $messenger->sendMessage($savedMessage);
    }

    public function testSendFYEOMessageAccountPassword(){
        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);

        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $messageOptions = new SecureMessageOptions();
        $messageOptions->setFYEOType(new FyeoType(FyeoTypeEnum::ACCOUNTPASSWORD));

        $secureMessage->setMessageOptions($messageOptions);
        $secureMessage->setPassword(self::$password);

        $savedMessage = $messenger->saveMessage($secureMessage);
        $messenger->sendMessage($savedMessage);
    }

    public function testSendFYEOMessageUniquePassword(){
        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);

        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $messageOptions = new SecureMessageOptions();
        $messageOptions->setFYEOType(new FyeoType(FyeoTypeEnum::UNIQUEPASSWORD));

        $secureMessage->setMessageOptions($messageOptions);
        $secureMessage->setPassword(self::$password);

        $savedMessage = $messenger->saveMessage($secureMessage);
        $messenger->sendMessage($savedMessage);
    }

    public function testSendMessageWithCRA(){
        $messenger = SecureMessenger::resolveViaServiceCode(self::$portalCode);
        $messenger->login(self::$credentials);

        $secureMessage = SecureMessageFactory::createNewMessage($messenger);

        $secureMessage->setTo([self::$recipientEmail]);
        $secureMessage->setSubject("DeliverySlip PHP Example");
        $secureMessage->setBody("Hello Test Message From DeliverySlip PHP Example");
        $secureMessage->setBodyFormat(new BodyFormatType(BodyFormatEnum::TEXT));

        $secureMessage->setCRACode("cracode");
        $secureMessage->inviteNewUsers(true);
        $secureMessage->sendNotifications(true);

        $savedMessage = $messenger->saveMessage($secureMessage);
        $messenger->sendMessage($savedMessage);
    }
}