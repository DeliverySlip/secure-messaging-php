<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 6/18/2018
 * Time: 11:39 AM
 */

namespace SecureMessaging\Models\Request;


class AuthenticateRequest
{
    public $authenticationToken = null;
    public $authenticationId = null;
    public $authenticationName = null;
    public $cookieless = false;
}