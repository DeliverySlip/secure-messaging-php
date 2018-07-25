<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 9:16 PM
 */

namespace SecureMessaging\Models;


interface IJSONSerializable
{
    public function generateJSONObject();
}