<?php

namespace App\Library\ReportAPI\Models;

class MerchantModel extends BaseModel {

    public $transactionId;

    function __construct() {
        parent::__construct();
    }

    public function validate() {
        return parent::validate();
    }

    public function validations() {
        return [
            "transactionId" => "transactionIdValidation",
        ];
    }
}
