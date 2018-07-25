<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 11:03 AM
 */

namespace SecureMessaging\Models\Request;


use SecureMessaging\Enums\BodyFormatEnum;

class SaveMessageRequest
{

    public $messageGuid = null;
    public $to = [];
    public $from = [];
    public $cc = [];
    public $bcc = [];
    public $subject = null;
    public $body = null;
    public $bodyFormat = BodyFormatEnum::TEXT;

    public $messageOptions; //new MessageOptionsRequest
}