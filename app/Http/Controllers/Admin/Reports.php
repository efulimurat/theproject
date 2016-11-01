<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Library\ReportAPI\Report;
use App\Library\ReportAPI\Models\ReportModel;
use App\Http\Requests\TransactionsReportFilter;

class Reports extends Controller {

    public function main() {
        $data = [
            "params" =>
            ["fromDate" => "",
                "toDate" => "",
                "merchant" => "",
                "acquirer" => ""
            ]
        ];
        return Report::Transaction()->viewContent("report.transactions.transactionsReportMain", $data);
    }

    public function all(TransactionsReportFilter $request) {

        if (!$request->isMethod('post')) {
            redirect()->route("reports.main");
        }

        $Report = new ReportModel;
        $Report->fromDate = $request->input("fromDate");
        $Report->toDate = $request->input("toDate");

        if ($request->input("merchant"))
            $Report->merchant = (int) $request->input("merchant");
        if ($request->input("acquirer"))
            $Report->acquirer = (int) $request->input("acquirer");

        $getReport = Report::Transaction()->getReport($Report)->fetchObject();
        $data = [
            "report" => $getReport,
            "params" =>
            ["fromDate" => $Report->fromDate,
                "toDate" => $Report->toDate,
                "merchant" => $Report->merchant,
                "acquirer" => $Report->acquirer
            ]
        ];

        $viewBlock = "report.transactions.transactionsReport";
        return Report::Transaction()->viewContent($viewBlock, $data);
    }

}
