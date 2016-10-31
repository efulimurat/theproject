<?php

namespace App\Library\ReportAPI\Modules;

use Session;
use \App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\MerchantModel;

class Merchant extends Report {
    /*
    public function checkLogin($byPass = false) {
        if ($byPass === true) {
            return false;
        } else {
            $token = Session::get(parent::TOKEN_SESSION_NAME);
            if ($token != null) {
                $merchant = new MerchantModel;
                $merchant->transactionId = "1";
                $dataAttempt = $this->requestData(parent::MerchantUrl, $merchant, true)->fetchArray();
                $resStatus = $dataAttempt["status"];
                if ($resStatus == "APPROVED") {
                    return true;
                } elseif ($resStatus == "DECLINED") {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
*/
    public function doLogin() {
        $merchant = new MerchantModel;
        $merchant->email = env("API_EMAIL");
        $merchant->password = env("API_PASSWORD");

        $loginData = $this->requestData(parent::LoginUrl, $merchant, 0, true)->fetchArray();
        if (!empty($loginData) && $loginData["status"] == "APPROVED") {
            return $loginData;
        } else {
            return false;
        }
    }

}
