<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 10:22 AM
 */

namespace SecureMessaging\SecureTypes;

use SecureMessaging\SecureTypes;
use SecureMessaging\Lib\BodyFormatEnum;


class BodyFormatType extends SecureTypes\PHP5String
{
    public function __construct($bodyFormat){
        parent::__construct($bodyFormat);

        switch($bodyFormat){

            case BodyFormatEnum::HTML:
                $this->value = $bodyFormat;
                break;
            case BodyFormatEnum::TEXT:
                $this->value = $bodyFormat;
                break;
            default:
                throw new SecureTypes\TypeException("BodyFormatType - Constructor Passed Parameter Is Not A BodyFormatType");
        }
    }
}