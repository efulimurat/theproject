@extends('layouts.app')

@section('content')
<?php
$customerInfo = true;
$colW = 6;
if (empty($transaction->customerInfo)) {
    $customerInfo = false;
    $colW = 12;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-{{$colW}}">
            <div class="jumbotron">
                <h1><a target="_blank" href="{{URL::route("merchants.detail",$transaction->transaction->merchant->transactionId)}}">{{ $transaction->merchant->name}}</a></h1>
                Transaction Details
                <ul>
                    @foreach($transaction->transaction->merchant as $key=>$value)
                    @if(is_object($value) || is_array($value))
                    <li>{{ucfirst($key)}} :
                        <ul>
                            @foreach($value as $keyS=>$valueS)
                            <li>{{ucfirst($keyS)}} : {{$valueS}}</li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li>{{ucfirst($key)}} : {{$value}}</li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @if($customerInfo)
        <div class="col-md-6 ">
            <div class="jumbotron">
                <h1>Customer</h1>
                Customer Details
                <ul>
                    @foreach($transaction->customerInfo as $key=>$value)
                    @if(is_object($value) || is_array($value))
                    <li>{{ucfirst($key)}} :
                        <ul>
                            @foreach($value as $keyS=>$valueS)
                            <li>{{ucfirst($keyS)}} : {{$valueS}}</li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li>{{ucfirst($key)}} : {{$value}}</li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>



</div>
@endsection