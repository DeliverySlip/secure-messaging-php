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
use SecureMessaging\SecureTypes\BodyFormatType;
use SecureMessaging\Lib\BodyFormatEnum;

class SecureMessage implements Lib\IJSONSerializable
{
    private $messageGuid = null;
    private $password = null;
    private $inviteNewUsers = true;
    private $sendNotification = true;
    private $craCode = null;

    private $to = [];
    private $from = [];
    private $cc = [];
    private $bcc = [];
    private $subject = null;
    private $body = null;
    private $bodyFormat = BodyFormatEnum::TEXT;

    private $messageOptions; // new SecureMessageOptions();


    public function __construct($messageGuid){
        $this->messageGuid = $messageGuid;

        $this->messageOptions = new SecureMessageOptions();
    }

    public function getMessageGuid(){
        return $this->messageGuid;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function inviteNewUsers($inviteNewUsers){
        $this->inviteNewUsers = $inviteNewUsers;
    }

    public function getInviteNewUsers(){
        return $this->inviteNewUsers;
    }

    public function sendNotifications($sendNotifications){
        $this->sendNotification = $sendNotifications;
    }

    public function getSendNotifications(){
        return $this->sendNotification;
    }

    public function setCRACode($craCode){
        $this->craCode = $craCode;
    }

    public function getCRACode(){
        return $this->craCode;
    }

    public function setTo(array $to){
        $this->to = $to;
    }

    public function getTo(){
        return $this->to;
    }

    public function setFrom(array $from){
        $this->from = $from;
    }

    public function getFrom(){
        return $this->from;
    }

    public function setCC(array $cc){
        $this->cc = $cc;
    }

    public function getCC(){
        return $this->cc;
    }

    public function setBCC(array $bcc){
        $this->bcc = $bcc;
    }

    public function getBCC(){
        return $this->bcc;
    }

    public function setMessageOptions(SecureMessageOptions $messageOptions){
        $this->messageOptions = $messageOptions;
    }

    public function getMessageOptions(){
        return $this->messageOptions;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBodyFormat(BodyFormatType $bodyFormatType){
        $this->bodyFormat = $bodyFormatType->value;
    }

    public function getBodyFormat(){
        return new BodyFormatType($this->bodyFormat);
    }

    /*public function __construct(SecureTypes\ActionType $actionCode, SecureTypes\PHP5String $password = null,
                                SecureTypes\PHP5String $parentGuid = null, SecureTypes\PHP5String $campainGuid = null){

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