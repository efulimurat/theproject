<?php

namespace App\Library\ReportAPI\Modules;

use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\TransactionModel;

class Transaction extends Report{
    
    public function getList($transaction) {
        //print_r((array)$transaction);
        return $this->requestData(parent::TransactionListUrl,$transaction);
    }
    
}