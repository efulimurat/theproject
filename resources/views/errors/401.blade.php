@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <?php $msgData = json_decode($exception->getMessage()); ?>
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-warning" role="alert">
                Something went wrong!<br>
                {{ $msgData->msg }}
            </div>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $msgData->reason }}
            </div>
        </div>
    </div>
</div>
@endsection