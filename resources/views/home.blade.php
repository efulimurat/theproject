@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-4">
                                <i class="fa fa-area-chart fa-3x" aria-hidden="true"></i><br>
                                <a href="{{ url('/administrator/transactions') }}">TRANSACTIONS</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
