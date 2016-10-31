<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Redis;
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

    public function all(Request $request, $page = 1, $view = "default") {

//        Redis::set('number',61);Redis::expire("number",120);
//      echo  $user = Redis::get('number');exit;

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

    public function infinityLoad(Request $request, $page = 1) {
        return self::all($request, $page, "ajax");
    }

}
