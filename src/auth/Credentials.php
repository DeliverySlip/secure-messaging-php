<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 8:06 PM
 */

namespace SecureMessaging\Auth;

use JsonSchema\Exception\InvalidConfigException;
use SecureMessaging\models\request\AuthenticateRequest;
use SecureMessaging\Models\Request\LoginRequest;
use SecureMessaging\Types;

class Credentials
{
    private $username = null;
    private $password = null;
    private $authenticationToken = null;

    public static function createWithUsernameAndPassword($username, $password){
        return new Credentials(["usernanme" => $username, "password" => $password]);
    }

    public static function createWithAuthenticationToken($authenticationToken){
        return new Credentials(["authenticationToken" => $authenticationToken]);
    }

    public function __construct(array $config){

        if (array_key_exists("authenticationToken", $config)){
            $this->authenticationToken = $config["authenticationToken"];
        }else if(array_key_exists("username", $config) && array_key_exists("password", $config)){
            $this->username = $config["username"];
            $this->password = $config["password"];
        }else{
            throw new InvalidConfigException("Invalid Configuration Passed For Credentials Object");
        }
    }

    public function generateRequestObjectForCredentials(){

        if($this->authenticationToken != null && $this->password != null && $this->username != null){
            throw new InvalidConfigException("An Authentication Token And Username and Password Have Been 
            Configured. Credentials can only be configured with one or the other. Check which configuration is desired 
            and that you are not using the same instance twice");
        }

        if($this->authenticationToken != null){
            $authenticationRequest = new AuthenticateRequest();
            $authenticationRequest->authenticationToken = $this->authenticationToken;
            return $authenticationRequest;
        }else if($this->username != null & $this->password != null){
            $loginRequest = new LoginRequest();
            $loginRequest->username = $this->username;
            $loginRequest->password = $this->password;
            return $loginRequest;
        }else{
            throw new InvalidConfigException("Invalid Configuration Passed For Credentials Object");
        }

    }

}