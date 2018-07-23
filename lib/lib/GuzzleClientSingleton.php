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
    private static $verifyCertificate = true;

    public static function disableCertificateVerification(){
        self::$verifyCertificate = false;
    }

    public static function getInstance(){
        if(self::$instance == null){

            $config = [
                "exceptions" => false
            ];

            if(self::$verifyCertificate == false){
                $config["verify"] = false;
            }

            self::$instance = new Client($config);
        }

        return self::$instance;
    }


    private final function __construct(){}

    public final function __destruct(){
        self::$instance = null;
    }
}