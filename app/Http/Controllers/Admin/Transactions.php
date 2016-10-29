<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function all(Request $request, $page = 1) {

//        print_R(dateValidation($fromDate));exit;
        $Transaction = new TransactionModel;
        $Transaction->fromDate = $request->get("fromDate");
        $Transaction->toDate = $request->get("toDate");
        $Transaction->status = $request->get("status");

        $list = Report::Transaction()->getList($Transaction)->fetchObject();
        $transactionStatusOptions = TransactionModel::statusOptions();
        return view("report.transactions", [
            "transactions" => $list,
            "statusOptions" => $transactionStatusOptions,
            "params" =>
                ["fromDate" => $Transaction->fromDate,
                 "toDate" => $Transaction->toDate,
                 "status" => $Transaction->status,
                 "merchantId" => $Transaction->merchantId
                ]
            ]
        );
    }

}
