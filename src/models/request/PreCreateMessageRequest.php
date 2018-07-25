<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/23/2018
 * Time: 4:59 PM
 */

namespace SecureMessaging\Models\Request;


class PreCreateMessageRequest
{
    public $actionCode = null;
    public $parentGuid = null;
    public $password = null;
    public $authAuditToken = null;
    public $campaignGuid = null;
    public $externalMessageId = null;
}