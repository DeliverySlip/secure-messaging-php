<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 6/18/2018
 * Time: 11:59 AM
 */

namespace SecureMessaging\Lib;

class HttpRequestHandler
{
    private $baseUrl = null;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function get($requestUrl, $requestHeaders){

        $client = GuzzleClientSingleton::getInstance();

        $options = [];
        if($requestHeaders != null){
            $options["headers"] = $requestHeaders;
        }

        $response = $client->get($requestUrl, $options);

        return new HttpResponseHandler($response);

    }

    public function post($requestUrl, array $requestHeaders = null, $requestObject = null){

        $client = GuzzleClientSingleton::getInstance();

        $options = [];
        if($requestHeaders != null){
            $options["headers"] = $requestHeaders;
        }

        if($requestObject != null){
            $jsonRequest = ClassToJsonConverter::convertToArray($requestObject);
            $options["json"] = $jsonRequest;
        }

        $response = $client->post($requestUrl, $options);

        return new HttpResponseHandler($response);
    }

    public function put($requestUrl, array $requestHeaders = null, $requestObject = null){

        $client = GuzzleClientSingleton::getInstance();

        $options = [];
        if($requestHeaders != null){
            $options["headers"] = $requestHeaders;
        }

        if($requestObject != null){
            $jsonRequest = ClassToJsonConverter::convertToArray($requestObject);
            $options["json"] = $jsonRequest;
        }

        $response = $client->put($requestUrl, $options);

        return new HttpResponseHandler($response);
    }

    public function delete($requestUrl, array $requestHeaders = null){

        $client = GuzzleClientSingleton::getInstance();

        $options = [];
        if($requestHeaders != null){
            $options["headers"] = $requestHeaders;
        }

        $response = $client->delete($requestUrl, $options);

        return new HttpResponseHandler($response);
    }
}