<?php

namespace SecureMessaging\SecureTypes;

use Exception;
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 16/04/16
 * Time: 10:38 AM
 */
class TypeException extends Exception
{

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}