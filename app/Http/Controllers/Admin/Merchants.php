<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\MerchantModel;

class Merchants extends Controller {
    /**
     * Merchant Details
     * @param type $merchantId
     * @return type
     */
    public function detail($transactionId) {
        $Merchant = new MerchantModel;
        $Merchant->transactionId = $transactionId;
        $details = Report::Merchant()->getDetails($Merchant)->fetchObject();
        $data = [
            "merchant" => $details
        ];
        return Report::Merchant()->viewContent("report.merchants.detail", $data);
    }

}
