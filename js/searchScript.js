function suggestions(){
    var po_number = $('#search_box_PO').val();
    var customer_sel = document.getElementById("customer_select");
    var customer_ID = customer_sel.options[customer_sel.selectedIndex].value;
    var first_date = $('#search_box_date_first').val();
    var last_date = $('#search_box_date_last').val();
    $.ajax({
        url : "../SearchPHP/search_suggestions.php",
        type: "POST",
        data : {po_number : po_number,
                customer_ID : customer_ID,
                first_date : first_date,
                last_date : last_date},
     success: function(data,status, xhr)
     {
        $( "#output" ).replaceWith(data);
     }
    })
}   
function setSessionID(po_ID){
    console.log(po_ID);
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {po_ID : po_ID},
     success: function(data,status, xhr)
     {
     }
    })
}   