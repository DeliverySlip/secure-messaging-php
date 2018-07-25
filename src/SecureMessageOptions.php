<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 10:26 AM
 */

namespace SecureMessaging;


use SecureMessaging\Lib\FyeoTypeEnum;
use SecureMessaging\SecureTypes\FyeoType;

class SecureMessageOptions
{

    private $allowForward = true;
    private $allowReply = true;
    private $allowTracking = true;
    private $fyeoType = FyeoTypeEnum::DISABLED;
    private $shareTracking = true;

    public function setAllowForward($allowForward){
        $this->allowForward = $allowForward;
    }

    public function getAllowForward(){
        return $this->allowForward;
    }

    public function setAllowReply($allowReply){
        $this->allowReply = $allowReply;
    }

    public function getAllowReply(){
        return $this->allowReply;
    }

    public function setAllowTracking($allowTracking){
        $this->allowTracking = $allowTracking;
    }

    public function getAllowTracking(){
        return $this->allowTracking;
    }

    public function setFYEOType(FyeoType $fyeoType){
        $this->fyeoType = $fyeoType->value;
    }

    public function getFYEOType(){
        return new FyeoType($this->fyeoType);
    }

    public function setShareTracking($allowShareTracking){
        $this->shareTracking = $allowShareTracking;
    }

    public function getShareTracking(){
        return $this->shareTracking;
    }


}