<?php

namespace App\Library\ReportAPI;

use \GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class Report {

    private $response;
    public $token;

    const TOKEN_SESSION_NAME = 'apiToken';
    const ApiBaseUrl = 'https://testreportingapi.clearsettle.com/';
    const LoginUrl = 'api/v3/merchant/user/login';
    const ReportUrl = 'api/v3/transaction/report';
    const TransactionListUrl = 'api/v3/transaction/list';
    const TransactionUrl = 'api/v3/transaction';
    const ClientUrl = 'api/v3/client';
    const MerchantUrl = 'api/v3/merchant';

    private $requestUrl, $requestData;

    public static function __callStatic($name, $arguments) {
        $_class = "\\App\\Library\\ReportAPI\\Modules\\" . $name;
        return new $_class();
    }

    public function requestData($url, $data, $passAuth = false) {

        $client = new \GuzzleHttp\Client([
            'base_uri' => self::ApiBaseUrl
        ]);

        $postData = [];

        $postData["form_params"] = (array) $data;

        if ($passAuth === false) {
            if (!$data->validate()) {
                $this->response = NULL;
                return $this;
            }
            $postData["headers"] = ["Authorization" => $this->token];
            $this->requestUrl = $url;
            $this->requestData = $data;
        }
        try {

            $res = $client->request("POST", $url, $postData);
            $responseData = $res->getBody()->getContents();
            $decodedData = json_decode($responseData, true);
            $this->response = $responseData;

            return $this->responseCheck();
        } catch (ClientException $e) {
            //print_R($e->getBody()->getContents());exit;
//               echo Psr7\str($e->getRequest());
            // echo $e->getResponse()->getStatusCode();
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse()->getStatusCode());
            }
        }
    }

    private function responseCheck() {
        if ($this->response == null) {
            return false;
        } else {
            $decoded = json_decode($this->response, true);
            if (isset($decoded["status"]) && $decoded["status"] == "DECLINED") {
                return $this->reSend();
            } else {
                return $this;
            }
        }
//        print_r($this->response);
    }

    private function reSend() {

        $loginRes = self::Merchant()->doLogin();
        if ($loginRes && $loginRes["status"] = "APPROVED") {
            $this->token = $loginRes["token"];
            return $this->requestData($this->requestUrl, $this->requestData);
        }
    }

    public function fetchArray() {
        return json_decode($this->response, true);
    }

    public function fetchObject() {
        return json_decode($this->response);
    }

    public function fetchJson() {
        return $this->response;
    }

}

?>