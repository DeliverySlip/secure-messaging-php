<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 11:05 AM
 */

namespace SecureMessaging\Models\Request;


use SecureMessaging\Enums\FyeoTypeEnum;

class MessageOptionsRequest
{

    public $allowForward = true;
    public $allowReply = true;
    public $allowTracking = true;
    public $fyeoType = FyeoTypeEnum::DISABLED;
    public $shareTracking = true;
}