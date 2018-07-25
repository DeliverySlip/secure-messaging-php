<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 6/18/2018
 * Time: 11:59 AM
 */

namespace SecureMessaging\Client;

use SecureMessaging\Utils\ClassToJsonConverter;

class HttpRequestHandler
{
    private $baseUrl = null;
    private $headerCallback = null;



    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseURL(){
        return $this->baseUrl;
    }


    public function setHeaderRequestEventListener($callback){
        $this->headerCallback = $callback;
    }

    public function get($requestUrl, array $requestHeaders = []){

        $client = GuzzleClientSingleton::getInstance();

        $additionalHeaders = [];
        if($this->headerCallback != null){
            $callback = $this->headerCallback;
            $additionalHeaders = $callback();
        }

        $allHeaders = array_merge($additionalHeaders, $requestHeaders);

        $options = [];
        if(count($allHeaders) > 0){
            $options["headers"] = $allHeaders;
        }

        $response = $client->get($this->baseUrl . "/" . $requestUrl, $options);

        return new HttpResponseHandler($response);

    }

    public function post($requestUrl, $requestObject = null, array $requestHeaders = []){

        $client = GuzzleClientSingleton::getInstance();

        $additionalHeaders = [];
        if($this->headerCallback != null){
            $callback = $this->headerCallback;
            $additionalHeaders = $callback();
        }

        $allHeaders = array_merge($additionalHeaders, $requestHeaders);

        $options = [];
        if(count($allHeaders) > 0){
            $options["headers"] = $allHeaders;
        }

        if($requestObject != null){
            $jsonRequest = ClassToJsonConverter::convertToArray($requestObject);
            $options["json"] = $jsonRequest;
        }

        $response = $client->post($this->baseUrl . "/" . $requestUrl, $options);

        return new HttpResponseHandler($response);
    }

    public function put($requestUrl, $requestObject = null, array $requestHeaders = []){

        $client = GuzzleClientSingleton::getInstance();

        $additionalHeaders = [];
        if($this->headerCallback != null){
            $callback = $this->headerCallback;
            $additionalHeaders = $callback();
        }

        $allHeaders = array_merge($additionalHeaders, $requestHeaders);

        $options = [];
        if(count($allHeaders) > 0){
            $options["headers"] = $allHeaders;
        }

        if($requestObject != null){
            $jsonRequest = ClassToJsonConverter::convertToArray($requestObject);
            $options["json"] = $jsonRequest;
        }

        $response = $client->put($this->baseUrl . "/" . $requestUrl, $options);

        return new HttpResponseHandler($response);
    }

    public function delete($requestUrl, array $requestHeaders = []){

        $client = GuzzleClientSingleton::getInstance();

        $additionalHeaders = [];
        if($this->headerCallback != null){

            $callback = $this->headerCallback;
            $additionalHeaders = $callback();
        }

        $allHeaders = array_merge($additionalHeaders, $requestHeaders);

        $options = [];
        if(count($allHeaders) > 0){
            $options["headers"] = $allHeaders;
        }

        $response = $client->delete($this->baseUrl . "/" . $requestUrl, $options);

        return new HttpResponseHandler($response);
    }
}