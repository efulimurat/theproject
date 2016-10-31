@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include("report.transactions.filterMenu")
        <div class="col-md-8 col-md-offset-2">
            @if(!empty($transactions))
            <div id='ajaxLoadT'>
                        @include("report.transactions.rowBlock")
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>TransactionsListPage = true;</script>