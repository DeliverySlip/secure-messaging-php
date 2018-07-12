<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 08/01/17
 * Time: 9:25 PM
 */

namespace SecureMessaging\Lib;


use GuzzleHttp\Client;

final class GuzzleClientSingleton
{
    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Client([
                "exceptions" => false
            ]);
        }

        return self::$instance;
    }


    private final function __construct(){}

    public final function __destruct(){
        self::$instance = null;
    }
}