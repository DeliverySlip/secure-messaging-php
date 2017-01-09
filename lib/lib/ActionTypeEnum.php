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
    const ACTIONTYPE_NEW = "New";
    const ACTIONTYPE_REPLY = "Reply";
    const ACTIONTYPE_REPLYALL = "ReplyAll";
    const ACTIONTYPE_FORWARD = "Forward";
}