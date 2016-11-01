<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\TransactionModel;

class Transactions extends Controller {
    
    public function dashboard(){
         return Report::Transaction()->viewContent("admin.welcome");
    }
    public function all(Request $request, $page = 1, $view = "default") {
        $Transaction = new TransactionModel;
        $Transaction->fromDate = $request->get("fromDate");
        $Transaction->toDate = $request->get("toDate");
        $Transaction->status = $request->get("status");
        if ($request->get("merchantId"))
            $Transaction->merchantId = (int) $request->get("merchantId");
        if ($page < 1)
            $page = 1;
        $Transaction->page = (int) $page;

        $list = Report::Transaction()->getList($Transaction)->fetchObject();
        $transactionStatusOptions = TransactionModel::statusOptions();
        $data = [
            "transactions" => $list,
            "statusOptions" => $transactionStatusOptions,
            "params" =>
            ["fromDate" => $Transaction->fromDate,
                "toDate" => $Transaction->toDate,
                "status" => $Transaction->status,
                "merchantId" => $Transaction->merchantId
            ]
        ];

        $viewBlock = $view == "ajax" ? "report.transactions.rowBlock" : "report.transactions.listBlock";
        return Report::Transaction()->viewContent($viewBlock, $data);
    }

    /**
     * Transactions Infinity Load
     * @param Request $request
     * @param integer $page
     * @return Transactions
     */
    public function infinityLoad(Request $request, $page = 1) {
        return self::all($request, $page, "ajax");
    }

    public function detail($transactionId) {
        $Transaction = new TransactionModel;
        $Transaction->transactionId = $transactionId;
        $details = Report::Transaction()->getDetails($Transaction)->fetchObject();
        $data = [
            "transaction" => $details
        ];
        return Report::Transaction()->viewContent("report.transactions.detail", $data);
    }

}
