<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:06 PM
 */

namespace SecureMessaging;

use SecureMessaging\SecureTypes;
use SecureMessaging\Lib;

class Credentials implements Lib\IJSONSerializable
{
    private $username;
    private $password;

    public function __construct(SecureTypes\String $username, SecureTypes\String $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function generateJSONObject()
    {
        $jsonObject = new \stdClass();
        $jsonObject->username = $this->username->toString();
        $jsonObject->password = $this->password->toString();

        return $jsonObject;

    }

}