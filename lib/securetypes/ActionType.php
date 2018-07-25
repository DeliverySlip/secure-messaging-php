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

class ActionType extends SecureTypes\PHP5String
{

    public function __construct($actionType){
        parent::__construct($actionType);

        switch($actionType){

            case ActionTypeEnum::ACTIONTYPE_NEW:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::ACTIONTYPE_FORWARD:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::ACTIONTYPE_REPLY:
                $this->value = $actionType;
                break;
            case ActionTypeEnum::ACTIONTYPE_REPLYALL:
                $this->value = $actionType;
                break;
            default:
                throw new SecureTypes\TypeException("ActionType - Constructor Passed Parameter Is Not An ActionType");
        }
    }
}