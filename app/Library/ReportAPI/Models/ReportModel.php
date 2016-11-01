<?php

namespace App\Library\ReportAPI\Models;

class ReportModel extends BaseModel {

    public $fromDate;
    public $toDate;
    public $merchant;
    public $acquirer;

    function __construct() {
        parent::__construct();
    }

    public function validate() {
        return parent::validate();
    }

    public function validations() {
        return [
            "fromDate" => "dateValidation",
            "toDate" => "dateValidation",
            "merchant" => "intValidation",
            "acquirer" => "intValidation"
        ];
    }

}
