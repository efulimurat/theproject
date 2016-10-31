<?php
//p($transactions);exit;
if (!empty($transactions)) {
    $nextPage = $transactions->current_page + 1;
    $urlParams = http_build_query($params);
}
?>
@if(!empty($transactions))
<table class="table table-responsive marB0">
    @if($transactions->current_page == 1)
    <thead>
        <tr>
            <td colspan="2">Merchant</td>
            <td>Status</td>
            <td>Total Amount</td>
            <td>Created Date</td>
        </tr>
    </thead>
    @endif
    <tbody>
        @foreach($transactions->data as $transaction)
        <tr class='{{ $statusOptions[$transaction->transaction->merchant->status]["class"] }}'>
            <td>{{$transaction->merchant->id}}</td>
            <td>{{$transaction->merchant->name}}</td>
            <td><b>{{$transaction->transaction->merchant->status}}</b></td>
            <td>{{ $transaction->fx->merchant->originalAmount }} {{ $transaction->fx->merchant->originalCurrency }}</td>
            <td>{{ FullDate1($transaction->created_at) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a class="jscroll-next colorG font14 fontWeightBold col-sm-12 col-xs-12 text-center" href="{{ URL::route('transactions.infinity',$nextPage, "ajax")."?".$urlParams }}">MORE</a>
@endif