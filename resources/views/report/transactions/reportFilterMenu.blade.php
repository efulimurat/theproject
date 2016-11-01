<div class='col-md-12'>
    <form class="form-inline" method="POST" action="{{ URL::route('reports.list') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="datepickerFromDate">From Date</label>
            <input type="text" class="form-control" id="datepickerFromDate" value="{{$params['fromDate']}}" name="fromDate">
        </div>
        <div class="form-group">
            <label for="datepickerToDate">To Date</label>
            <input type="text" class="form-control" id="datepickerToDate" value="{{$params['toDate']}}" name="toDate">
        </div>
        <div class="form-group">
            <label for="datepickerFromDate">Merchant ID</label>
            <input type="text" class="form-control" value="{{$params['merchant']}}" name="merchant">
        </div>
        <div class="form-group">
            <label for="datepickerFromDate">Acquirer </label>
            <input type="text" class="form-control" value="{{$params['acquirer']}}" name="acquirer">
        </div>
       
        <button type="submit" class="btn btn-default pull-right">Report</button>
    </form>
</div>