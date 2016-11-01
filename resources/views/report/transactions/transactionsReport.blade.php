@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include("report.transactions.reportFilterMenu")
    </div>
    
    <div class="row marT10">
        @foreach($report->response as $item)
        <div class="col-md-6">
            <div class="jumbotron text-center">
                <h1>{{$item->currency}}</h1>
                <p>{{currencyFormat($item->total)}}</p>
                <p>{{$item->count}} Transaction</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection