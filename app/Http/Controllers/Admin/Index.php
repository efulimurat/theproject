<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\TransactionModel;

class Transactions extends Controller {
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($method = "dashboard") {
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return $this->dashboard();
        }
    }

    public function dashboard() {
        return view("home");
    }

    public function transactions() {
        $Transaction = new TransactionModel;
        $Transaction->fromDate = "2016-01-01";
        $Transaction->toDate = "2016-09-01";
        $list = Report::Transaction()->getList($Transaction)->fetchObject();
        $transactionStatusOptions = TransactionModel::statusOptions();
//        print_R($list);exit;
        return view("report.transactions", [
            "transactions" => $list,
            "statusOptions" => $transactionStatusOptions
                ]
        );
    }
    
    public function listme($v1){
        echo $v1."!!"; exit;
    }
    

}
