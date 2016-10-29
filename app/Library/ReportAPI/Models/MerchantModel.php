<?php

namespace App\Library\ReportAPI\Models;

class MerchantModel extends BaseModel {

    function __set($key, $val) {
        $this->$key = $val;
    }
    
    public function validate(){
        return parent::validate();
    }
}
