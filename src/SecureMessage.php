<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 9:56 PM
 */

namespace SecureMessaging;

use SecureMessaging\Lib;
use SecureMessaging\SecureTypes;

class SecureMessage
{

    private $actionCode;
    private $parentGuid;
    private $password;
    private $campaignGuid;

    public function __construct(SecureTypes\ActionType $actionCode, SecureTypes\String $parentGuid = null,
                                SecureTypes\String $password = null, SecureTypes\String $campainGuid = null){

        switch($actionCode->toString()){
            case Lib\ActionTypeEnum::NEW:
                break;
            case Lib\ActionTypeEnum::FORWARD || ActionTypeEnum::REPLY || Lib\ActionTypeEnum::REPLYALL:
                if($parentGuid == null){
                    throw new \InvalidArgumentException("SecureMessage - Constructor - Parent Guid Is Required For FORWARD, REPLY and REPLYALL");
                }
                break;
            default:
                throw new SecureTypes\TypeException("SecureMessage - Constructor - Invalid ActionType Passed. Cannot Process");
        }

    }
}