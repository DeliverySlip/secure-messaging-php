<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 12:33 PM
 */

namespace SecureMessaging\Models\Request;


class SendMessageRequest
{

    public $messageGuid = null;
    public $password = null;
    public $inviteNewUsers = true;
    public $sendEmailNotification = true;
    public $craCode = null;
}