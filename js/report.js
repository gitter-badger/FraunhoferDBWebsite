function applyFilter(){
    var customer_sel    = document.getElementById("customer_select");
    var customer_ID     = customer_sel.options[customer_sel.selectedIndex].value;
    var group_by_select = document.getElementById("group_by_select");
    var date_type       = group_by_select.options[group_by_select.selectedIndex].value;
    var date_from       = $('#date_from').val();
    var date_to         = $('#date_to').val();
    $.ajax({
        url : "reportGenerate.php",
        type: "POST",
        data : {customer_ID : customer_ID,
                date_from   : date_from,
                date_to     : date_to,
                date_type   : date_type},
     success: function(data,status, xhr)
     {
        $( "#output" ).replaceWith(data);
     }
    })
}  