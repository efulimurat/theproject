<?php

namespace App\Library\ReportAPI\Modules;

use Session;
use \App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\BaseModel;
use App\Library\ReportAPI\Models\MerchantModel;

class Merchant extends Report {
    
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
    
    public function getDetails(BaseModel $merchant) {
        return $this->requestData(parent::MerchantUrl, $merchant, 180);
    }

}
