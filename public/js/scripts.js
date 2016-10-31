$(function () {

    //Transactions List
    if (typeof TransactionsListPage != "undefined") {
        //Transactions infinity load
        var _loadingHtml = '<div class="spinner">' +
                '<div class="bounce1"></div>' +
                '<div class="bounce2"></div>' +
                '<div class="bounce3"></div>' +
                '</div>';
        $("#ajaxLoadT").jscroll({
            loadingHtml: _loadingHtml,
            nextSelector: "a.jscroll-next:last",
            autoTrigger: false
        });
        //DatePicker for transactions filter
        $("#datepickerFromDate,#datepickerToDate").datepicker({dateFormat: 'yy-mm-dd'});

        //Filter
        $("#transactionsStatusFilter option[value='" + $("#transactionsStatusFilter").attr("data-selected") + "']").attr("selected", true);
    }
})