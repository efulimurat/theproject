<?php

namespace App\Library\ReportAPI\Modules;

use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\BaseModel;

/**
 * Transactions Module
 */
class Transaction extends Report {

    /**
     * Get list of transactions which filtered by model
     * @param BaseModel $transaction transaction model obj
     * @return Report\requestData
     */
    public function getList(BaseModel $transaction) {
        $urlPageStr = "";
        if ($transaction->page > 1)
            $urlPageStr = "?page=" . $transaction->page;
        return $this->requestData(parent::TransactionListUrl . $urlPageStr, $transaction, 60);
    }

    public function getDetails(BaseModel $transaction) {
        return $this->requestData(parent::TransactionUrl, $transaction, 180);
    }
    
    public function getReport(BaseModel $report){
        return $this->requestData(parent::ReportUrl, $report, 30);
    }

}
