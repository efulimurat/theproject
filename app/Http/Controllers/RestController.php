<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Middleware\ApiAuthentication;
use Session;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class RestController extends Controller {

    public function __construct() {
        $this->middleware('api.auth');
    }

    public function getTest() {

        $doLogin = ApiAuthentication::apiLogin();
        $loginResponse = json_decode($doLogin, true);
        if (!empty($loginResponse)) {
            Session::set('apiToken', $loginResponse["token"]);
        }
    }

    public function getDataFromUrl($url) {

        $email = env("API_EMAIL");
        $password = env("API_PASSWORD");

        $client = new \GuzzleHttp\Client();
//        $client->setDefaultOption('verify', false);
        $res = $client->request('POST', "https://testreportingapi.clearsettle.com/api/v3/merchant/user/login", ['form_params' => [
                'email' => $email,
                'password' => $password,
            ]
        ]);
        $login_result = (json_decode($res->getBody(), true));

        $client = new \GuzzleHttp\Client();
        
      try {
    $res = $client->request("POST", "https://testreportingapi.clearsettle.com/api/v3/transactions/list", [
                'form_params' => ['fromDate' => "2010-01-01", 'toDate' => '2016-12-12'],
                'headers' => ['Authorization' => $login_result["token"]."."]
            ]);
} catch (RequestException $e) {
    //echo Psr7\str($e->getRequest());
    echo $e->getResponse()->getStatusCode();
    if ($e->hasResponse()) {
        echo Psr7\str($e->getResponse()->getStatusCode());
    }
}
      exit;
        try {

//            $client->setDefaultOption('exceptions', false);
            $res = $client->request("POST", "https://testreportingapi.clearsettle.com/api/v3/transaction/list", [
                'form_params' => ['fromDate' => "2010-01-01", 'toDate' => '2016-12-12'],
                'headers' => ['Authorization' => $login_result["token"]."."]
            ]);
        } catch (GuzzleHttp\Exception\ServerException $e) {
            echo $response = $e->getStatusCode();
            $responseBodyAsString = $response->getBody()->getContents();
        }
        echo $res->getStatusCode();
        print_R((json_decode($res->getBody(), true)));



        return "aa";
//        if ($server_output === false) {
//            echo 'Curl hatası: ' . curl_error($ch);
//            return false;
//        } else {
//            return $server_output;
//        }
//        $doLogin = ApiAuthentication::apiLogin();
//        $loginResponse = json_decode($doLogin,true);
//        if(!empty($loginResponse)){
//            Session::set('apiToken', $loginResponse["token"]);
//        }
    }

}
