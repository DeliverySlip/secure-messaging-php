<?php

namespace SecureMessaging\SecureTypes;

use SecureMessaging\SecureTypes;
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 10:13 PM
 */
class Numeric extends SecureTypes\Primitive
{

    public function __construct($numeric){
        if(is_numeric($numeric)){
            $this->value = $numeric;
        }else{
            throw new TypeException("Numeric - Constructor Passed Parameter Is Not A Numeric");
        }
    }

    public function toString(){
        return strval($this->value);
    }


}