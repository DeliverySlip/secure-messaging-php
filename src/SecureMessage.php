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

class SecureMessage implements Lib\IJSONSerializable
{

    private $actionCode;
    private $parentGuid;
    private $password;
    private $campaignGuid;

    private $messageGuid;

    public function __construct($messageGuid){
        $this->messageGuid = $messageGuid;
    }

    /*public function __construct(SecureTypes\ActionType $actionCode, SecureTypes\String $password = null,
                                SecureTypes\String $parentGuid = null, SecureTypes\String $campainGuid = null){

        $this->actionCode = $actionCode;
        $this->parentGuid = $parentGuid;
        $this->password = $password;
        $this->campaignGuid = $campainGuid;

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

    }*/

    public function generateJSONObject()
    {
        /*$jsonObject = new \stdClass();

        if($this->actionCode != null){
            $jsonObject->actionCode = $this->actionCode->toString();
        }

        if($this->parentGuid != null){
            $jsonObject->parentGuid = $this->password->toString();
        }

        if($this->password != null){
            $jsonObject->password = $this->password->toString();
        }

        if($this->campaignGuid != null){
            $jsonObject->campainGuid = $this->campaignGuid->toString();
        }

        return $jsonObject;*/
    }
}