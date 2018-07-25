<?php

namespace SecureMessaging\Types;

use SecureMessaging\Types;
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 10:12 PM
 */
class PHP5String extends Types\Primitive
{

    public function __construct($string){
        if(is_string($string)){
            $this->value = $string;
        }else{
            throw new Types\TypeException("PHP5String - Constructor Passed Parameter Is Not A PHP5String");
        }
    }

    public function isEmpty(){
        return empty($this->value);
    }

    public function length(){
        return strlen($this->value);
    }

    public function append($string){
        $this->value += $string;
    }

    public function substring($start, $end = null){

        if($end == null){
            $length = $this->length();
            return substr($this->value, $start->value, ($length - $start->value));
        }else{
            return substr($this->value, $start->value, ($end->value - $start->value));
        }
    }

    public function toString(){
        return strval($this->value);
    }


}