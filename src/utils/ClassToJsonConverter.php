<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 6/18/2018
 * Time: 11:55 AM
 */

namespace SecureMessaging\Utils;


class ClassToJsonConverter
{

    public static function convertToStdClass($class){

        $classVariables = get_object_vars($class);
        $stdClass = new \stdClass();
        foreach($classVariables as $variable => $value){
            if($value != null){ //only add items that have had a value defined for them
                $stdClass->$variable = $value;
            }

        }

        return $stdClass;
    }

    public static function convertToArray($class){
        $classVariables = get_object_vars($class);
        $array = array();
        foreach($classVariables as $variable => $value){
            if($value != null){ //only add items that have had a value defined for them
                $array[$variable] = $value;
            }

        }

        return $array;
    }
}