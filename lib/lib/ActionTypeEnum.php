<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 06/01/17
 * Time: 10:04 PM
 */

namespace SecureMessaging\Lib;

use SecureMessaging\SecureTypes;

final class ActionTypeEnum
{
    const NEW = "New";
    const REPLY = "Reply";
    const REPLYALL = "ReplyAll";
    const FORWARD = "Forward";
}