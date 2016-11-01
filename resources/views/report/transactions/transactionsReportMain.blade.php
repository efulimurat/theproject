@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Transactions Report</h1>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            From Date is required
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            To Date is required
        </div>
    </div>
    <div class="row">
        @include("report.transactions.reportFilterMenu")
        <div class="col-md-8 col-md-offset-2">

        </div>
    </div>
</div>
@endsection
<script>TransactionsListPage = true;</script>