@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="jumbotron">
                <h1>{{ $merchant->merchant->name}}</h1>
                Merchant Details
                <ul>
                    @foreach($merchant->transaction->merchant as $key=>$value)
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
        
    </div>

    

</div>
@endsection