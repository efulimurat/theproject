@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class='col-md-12'>
            <form class="form-inline" method="GET" action="{{ URL::route('transactions.list',1) }}">
                <div class="form-group">
                    <label for="datepickerFromDate">Merhant ID</label>
                    <input type="text" class="form-control" value="{{$params['merchantId']}}" name="merchantId">
                </div>
                <div class="form-group">
                    <label for="datepickerFromDate">From Date</label>
                    <input type="text" class="form-control" id="datepickerFromDate" value="{{$params['fromDate']}}" name="fromDate">
                </div>
                <div class="form-group">
                    <label for="datepickerToDate">To Date</label>
                    <input type="text" class="form-control" id="datepickerToDate" value="{{$params['toDate']}}" name="toDate">
                </div>
                <div class="form-group">
                    <label for="sel1">Status:</label>
                    <select class="form-control" id="transactionsStatusFilter" name="status" data-selected="{{$params['status']}}">
                        <option selected value="">Select Status</option>
                        @foreach($statusOptions as $status=>$values)
                        <option value='{{ $status }}'>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
        <div class="col-md-8 col-md-offset-2">
            @if(!empty($transactions))
            <?php $nextPage = $transactions->current_page + 1; ?>
            <div id='ajaxLoadT'>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <td>TransactionID</td>
                            <td>Customer</td>
                            <td>Status</td>
                            <td>Total Amount</td>
                            <td>Created Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $urlParams = http_build_query($params);
                        ?>
                        @foreach($transactions->data as $transaction)
                        <tr class='{{ $statusOptions[$transaction->transaction->merchant->status]["class"] }}'>
                            <td>{{$transaction->transaction->merchant->transactionId}}</td>
                            <td>@if(isset($transaction->customerInfo))
                                {{$transaction->customerInfo->billingFirstName}} {{$transaction->customerInfo->billingLastName}}
                                @endif
                            </td>
                            <td><b>{{$transaction->transaction->merchant->status}}</b></td>
                            <td>{{ $transaction->fx->merchant->originalAmount }} {{ $transaction->fx->merchant->originalCurrency }}</td>
                            <td>{{ FullDate1($transaction->created_at) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="jscroll-next colorG font14 fontWeightBold col-sm-12 col-xs-12 text-center" href="{{ URL::route('transactions.infinity',$nextPage)."?".$urlParams }}">MORE</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>TransactionsListPage = true;</script>