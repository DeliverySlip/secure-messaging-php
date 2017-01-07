<?php

namespace SecureMessaging\SecureTypes;

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 16/04/16
 * Time: 10:42 AM
 */
abstract class Primitive
{
    public $value;

    abstract function toString();

    public function __toString(){
        return strval($this->value);
    }
}