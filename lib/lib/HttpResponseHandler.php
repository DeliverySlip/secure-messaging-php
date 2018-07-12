<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 6/18/2018
 * Time: 12:07 PM
 */

namespace SecureMessaging\Lib;

use Psr\Http\Message\ResponseInterface;

class HttpResponseHandler
{
    private $response;

    public function __construct(ResponseInterface $guzzleResponseObject)
    {
        $this->response = $guzzleResponseObject;
    }

    public function getStatusCode(){
        return $this->response->getStatusCode();
    }

    public function deserializeBodyIntoObject($class){

    }
}