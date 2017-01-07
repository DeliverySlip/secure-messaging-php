<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 10:18 PM
 */

namespace SecureMessaging\SecureTypes;

use SecureMessaging\SecureTypes;
use SecureMessaging\Lib\ActionTypeEnum;

class ActionType extends SecureTypes\String
{

    public function __construct($actionType){
        parent::__construct($actionType);

        switch($actionType){

            case ActionTypeEnum::NEW:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::FORWARD:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::REPLY:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::REPLYALL:
                $this->value = $actionType;
                break;
            default:
                throw new SecureTypes\TypeException("ActionType - Constructor Passed Parameter Is Not An ActionType");
        }
    }
}