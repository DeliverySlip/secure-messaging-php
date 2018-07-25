<?php

namespace SecureMessaging\SecureTypes;

//require_once(__DIR__ . "/../../vendor/autoload.php");

use SecureMessaging\SecureTypes;
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 10:12 PM
 */
class PHP5String extends SecureTypes\Primitive
{

    public function __construct($string){
        if(is_string($string)){
            $this->value = $string;
        }else{
            throw new SecureTypes\TypeException("PHP5String - Constructor Passed Parameter Is Not A PHP5String");
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

    public function substring(SecureTypes\Integer $start, SecureTypes\Integer $end = null){

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