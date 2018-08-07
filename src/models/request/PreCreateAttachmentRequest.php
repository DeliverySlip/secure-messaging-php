<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 8/7/2018
 * Time: 11:35 AM
 */

namespace SecureMessaging\Models\Request;


class PreCreateAttachmentRequest
{

    public $messageGuid = null;
    public $attachmentPlaceholders = [];
}