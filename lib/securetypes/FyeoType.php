<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 10:41 AM
 */

namespace SecureMessaging\SecureTypes;

use SecureMessaging\SecureTypes;
use SecureMessaging\Lib\FyeoTypeEnum;

class FyeoType extends SecureTypes\PHP5String
{

    public function __construct($fyeoType)
    {
        parent::__construct($fyeoType);

        switch ($fyeoType) {

            case FyeoTypeEnum::DISABLED:
                $this->value = $fyeoType;
                break;
            case FyeoTypeEnum::ACCOUNTPASSWORD:
                $this->value = $fyeoType;
                break;
            case FyeoTypeEnum::UNIQUEPASSWORD:
                $this->value = $fyeoType;
                break;
            default:
                throw new SecureTypes\TypeException("FyeoType - Constructor Passed Parameter Is Not A FyeoType");
        }

    }
}