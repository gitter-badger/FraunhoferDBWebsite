function applyFilter(){
    var customer_sel = document.getElementById("customer_select");
    var customer_ID = customer_sel.options[customer_sel.selectedIndex].value;
    $.ajax({
        url : "reportGenerate.php",
        type: "POST",
        data : {customer_ID : customer_ID},
     success: function(data,status, xhr)
     {
        $( "#output" ).replaceWith(data);
     }
    })
}  