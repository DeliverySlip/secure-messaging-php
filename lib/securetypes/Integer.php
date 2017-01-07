<?php

namespace SecureMessaging\SecureTypes;

use SecureMessaging\SecureTypes;
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 10:12 PM
 */
class Integer extends SecureTypes\Numeric
{

    public function __construct($integer){
        parent::__construct($integer);
        if(is_int($integer)){
            $this->value = $integer;
        }else{
            throw new TypeException("Integer - Constructor Passed Parameter Is Not An Integer");
        }
    }
}