<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 10:32 PM
 */

namespace SecureMessaging;

use GuzzleHttp\Client;
use SecureMessaging\Lib\ActionTypeEnum;
use SecureMessaging\SecureTypes;
use SecureMessaging\SecureTypes\ActionType;

class SecureMessageFactory
{

    public static function createNewMessage(SecureMessenger $messenger){

        $preCreateConfiguration = new PreCreateConfiguration();
        $preCreateConfiguration->setActionCode(new ActionType(ActionTypeEnum::ACTIONTYPE_NEW));

        $secureMessage = $messenger->preCreateMessage($preCreateConfiguration);
        return $secureMessage;
    }

    public static function createReplyToMessage(SecureMessenger $messenger, SecureMessage $message){

        $preCreateConfiguration = new PreCreateConfiguration();
        $preCreateConfiguration->setActionCode(new ActionType(ActionTypeEnum::ACTIONTYPE_REPLY));
        $preCreateConfiguration->setParentGuid($message->getMessageGuid());

        $secureMessage = $messenger->preCreateMessage($preCreateConfiguration);
        return $secureMessage;
    }

    public static function createReplyAllToMessage(SecureMessenger $messenger, SecureMessage $message){

        $preCreateConfiguration = new PreCreateConfiguration();
        $preCreateConfiguration->setActionCode(new ActionType(ActionTypeEnum::ACTIONTYPE_REPLYALL));
        $preCreateConfiguration->setParentGuid($message->getMessageGuid());

        $secureMessage = $messenger->preCreateMessage($preCreateConfiguration);
        return $secureMessage;
    }



}