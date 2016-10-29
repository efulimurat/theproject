$(function () {

    //Transactions List
    if (typeof TransactionsListPage != "undefined") {
        //Transactions infinity load
        $("#ajaxLoadT").jscroll({
            loadingHtml: 'Loading',
            nextSelector: "a.jscroll-next:last",
            autoTriggerUntil: 5,
            contentSelector: 'table'
        });
        //DatePicker for transactions filter
        $("#datepickerFromDate,#datepickerToDate").datepicker({dateFormat: 'yy-mm-dd'});

        //Filter
        $("#transactionsStatusFilter option[value='"+$("#transactionsStatusFilter").attr("data-selected")+"']").attr("selected",true);
    }
})