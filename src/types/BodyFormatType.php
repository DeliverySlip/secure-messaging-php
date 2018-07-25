<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/24/2018
 * Time: 10:22 AM
 */

namespace SecureMessaging\Types;

use SecureMessaging\Types;
use SecureMessaging\Enums\BodyFormatEnum;


class BodyFormatType extends Types\PHP5String
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
                throw new Types\TypeException("BodyFormatType - Constructor Passed Parameter Is Not A BodyFormatType");
        }
    }
}