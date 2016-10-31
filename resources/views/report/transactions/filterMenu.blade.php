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
        <button type="submit" class="btn btn-default pull-right">Search</button>
    </form>
</div>