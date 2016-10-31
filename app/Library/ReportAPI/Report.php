<?php

namespace App\Library\ReportAPI;

use App\Modules\Base;
use App\Modules\Errors;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Redis;

/**
 * Report Class is about Transaction Report requests and datas
 * 
 */
class Report extends Base {

    /** @var string Api Token Cache KeyName */
    const TOKEN_CACHE_KEY = 'apiToken';

    /** @var integer Api Token Cache Expire Time | 600 seconds */
    const TOKEN_CACHE_EXPIRE = 600;

    /** @var string API Base Url */
    const ApiBaseUrl = 'https://testreportingapi.clearsettle.com/';

    /** @var string API Login Url */
    const LoginUrl = 'api/v3/merchant/user/login';

    /** @var string API Report Url */
    const ReportUrl = 'api/v3/transaction/report';

    /** @var string API Transactions List Url */
    const TransactionListUrl = 'api/v3/transaction/list';

    /** @var string API Transaction Detail Url */
    const TransactionUrl = 'api/v3/transaction';

    /** @var string API Client Url */
    const ClientUrl = 'api/v3/client';

    /** @var string API Merchant Url */
    const MerchantUrl = 'api/v3/merchant';

    /**
     * 
     * @var string[] API Response Data
     */
    public $response;

    /**
     * 
     * @var integer API Response Status
     */
    private $responseStatus;

    /**
     *
     * @var string API auth header 
     */
    private $token;

    /**
     * Request Data Params
     * @var  
     */
    private $requestUrl, $requestData, $passAuth;

    /**
     *
     * @var integer Data Cache Timeout
     */
    private $cacheExpire = 60;

    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return \App\Library\ReportAPI\_class
     */
    public static function __callStatic($name, $arguments) {
        $_class = "\\App\\Library\\ReportAPI\\Modules\\" . $name;
        return new $_class();
    }

    public function __construct() {
        parent::__construct();
    }

    /**
     * Requests Data from API
     * @param type $url
     * @param type $data
     * @param type $cacheExpire
     * @param type $passAuth
     * @return \App\Library\ReportAPI\Report
     */
    public function requestData($url, $data, $cacheExpire = 60, $passAuth = false) {
//Redis::del(self::TOKEN_CACHE_KEY);Exit;
        //     $this->token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJhZG1pbiIsIm1lcmNoYW50SWQiOjMsInN1Yk1lcmNoYW50SWRzIjpbMyw3NCw5MywxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNzUsMTg0LDIyMCwyMjEsMjIyLDIyMywyOTQsMzIyLDMyMywzMjcsMzI5LDMzMCwzNDksMzkwLDM5MV0sInRpbWVzdGFtcCI6MTQ3Nzg3MDUxNH0.v088uhTi9j0spRbN92Rc07TXAUvqawCZLCf0WJZ2W9a";
        $this->token = Redis::get(self::TOKEN_CACHE_KEY);
        $this->requestUrl = $url;
        $this->requestData = $data;
        if ($cacheExpire > 0) {
            $this->cacheKey = self::createDataCacheKey($data);
            $this->cacheExpire = $cacheExpire > 0 ? $cacheExpire : $this->cacheExpire;
        }
        $client = new \GuzzleHttp\Client([
            'base_uri' => self::ApiBaseUrl
        ]);

        $this->passAuth = $passAuth;
        $postData = [];

        $postData["form_params"] = (array) $data;

        if ($passAuth === false) {
            if ($this->token == "") {
                return self::reSend();
            }

            if (!$data->validate()) {
                $this->response = NULL;
                return $this;
            }
            $postData["headers"] = ["Authorization" => $this->token];


            $checkDataCached = self::getDataCached($this);
            if ($checkDataCached != false) {
                $getDataCached = Redis::get($this->cacheKey);
                $this->response = $getDataCached;
                return $this;
            }
        }
        try {
            $res = $client->request("POST", $url, $postData);
            $responseData = $res->getBody()->getContents();
            $this->response = $responseData;
            $this->responseStatus = $res->getStatusCode();
            return $this->responseCheck();
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $status = $response->getStatusCode();
            $responseStr = $response->getBody()->getContents();
            $responseMsg = json_decode($responseStr)->message;
            $Errors = new Errors;
            $Errors->setErrorByStatus($status, $responseMsg);
        }
    }

    /**
     * Generates Cache Key Name
     * @param type $data
     * @return strıng
     */
    private function createDataCacheKey($data) {
        $filledKeys = [];
        foreach ($data as $key => $value) {
            if (($value)) {
                $filledKeys[] = $key . ":" . $value;
            }
        }
        if (!empty($filledKeys)) {
            return implode("*", $filledKeys);
        }
        return "";
    }

    /**
     * Get Token from Cache
     * @return string
     */
    private function getTokenCached() {
        return Redis::get(self::TOKEN_CACHE_KEY);
    }

    /**
     * Check requested data response of API
     * 
     * Validates api login is successfull
     * 
     * Validates data request
     * 
     * @return boolean
     */
    private function responseCheck() {
        if ($this->response == null) {
            return false;
        } else {
            $decoded = json_decode($this->response, true);

            if (isset($decoded["status"]) && ($decoded["status"] == "DECLINED" )) {
                if ($this->responseStatus == 401) {
                    return $this->reSend();
                } else {
                    $apiResponse = json_decode($this->response);
                    $this->response = "";
                    $Errors = new Errors;
                    return $Errors->setError("ApiReason", $apiResponse->message);
                }
            } else {
                return self::setDataCache();
            }
        }
//        print_r($this->response);
    }

    /**
     * 
     * @return void
     */
    private function reSend() {
        $loginRes = self::Merchant()->doLogin();
        if ($loginRes && $loginRes["status"] = "APPROVED") {
            Redis::set(self::TOKEN_CACHE_KEY, $loginRes["token"]);
            Redis::expire(self::TOKEN_CACHE_KEY, self::TOKEN_CACHE_EXPIRE);
            return $this->requestData($this->requestUrl, $this->requestData, $this->cacheExpire);
        }
    }

    /**
     * Caches returned data from API
     * @return \App\Library\ReportAPI\Report
     */
    private function setDataCache() {
        if ($this->passAuth == false) {
            Redis::set($this->cacheKey, $this->response);
            Redis::expire($this->cacheKey, $this->cacheExpire);
        }
        return $this;
    }

    /**
     * Get CacheKey Data from Redis
     * @return void
     */
    private function getDataCached() {
        return Redis::exists($this->cacheKey) == 1 ? true : false;
    }

    /**
     * Return API response data as array
     * @return type
     */
    public function fetchArray() {
        return parent::fetchJsonDataAsArray($this->response);
    }

    /**
     * Return API response data as object
     * @return type
     */
    public function fetchObject() {
        return parent::fetchJsonDataAsObject($this->response);
    }

}

?>