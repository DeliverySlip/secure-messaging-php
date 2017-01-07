<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 9:47 PM
 */

namespace SecureMessaging;

use SecureMessaging\SecureTypes;

class Session
{

    private $sessionToken;

    public function __construct(SecureTypes\String $sessionToken){
        $this->sessionToken;
    }

    public function getSessionToken(){
        return $this->sessionToken;
    }
}