<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 9:10 AM
 */

namespace SecureMessaging;


use SecureMessaging\Lib\ActionTypeEnum;
use SecureMessaging\SecureTypes\ActionType;

class PreCreateConfiguration
{
    private $actionCode = null;
    private $parentGuid = null;
    private $password = null;

    public function setActionCode(ActionType $actionCode){
        $this->actionCode = $actionCode->value;
    }

    public function setParentGuid($parentGuid){
        $this->parentGuid = $parentGuid;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getParentGuid(){
        return $this->parentGuid;
    }

    public function getActionCode(){
        return new ActionType($this->actionCode);
    }
}