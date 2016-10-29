<?php

namespace App\Library\ReportAPI\Models;

class TransactionModel extends BaseModel {

    public $fromDate;
    public $toDate;
    public $status;
    public $merchantId;
    
    public $validations = [
        "fromDate" => "dateValidation",
        "toDate" => "dateValidation",
        "status" => "statusValidation",
        "merchantId" => "intValidation"
    ];

    function __construct() {
        parent::__construct();
    }

    public function validate() {
        return parent::validate();
    }

    public static function statusOptions() {
        return [
            "APPROVED" => [
                "color" => "green",
                "class" => "success"
            ],
            "WAITING" => [
                "color" => "yellow",
                "class" => "info"
            ],
            "DECLINED" => [
                "color" => "gray",
                "class" => "warning"
            ],
            "ERROR" => [
                "color" => "darkred",
                "class" => "danger"
            ]
        ];
    }

    public function statusValidation($status) {
        $statusList = array_keys($this->statusOptions());
        if (in_array($status, $statusList)) {
            return true;
        } else {
            return false;
        }
    }

}
