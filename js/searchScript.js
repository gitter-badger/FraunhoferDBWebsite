function suggestions(){
    var po_number = $('#search_box_PO').val();
    var customer_sel = document.getElementById("customer_select");
    var customer_ID = customer_sel.options[customer_sel.selectedIndex].value;
    var first_date = $('#search_box_date_first').val();
    var last_date = $('#search_box_date_last').val();
    //var exact_date = $('#search_box_date_last').val();
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
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {po_ID : po_ID},
     success: function(data,status, xhr)
     {
     }
    })
}  
function run_suggestions(){
    var run_number = $('#search_box_run').val();
    var machine_sel = document.getElementById("machine_select");
    var machine_ID = machine_sel.options[machine_sel.selectedIndex].value;
    var coating_sel = document.getElementById("coating_select");
    var coating_ID = coating_sel.options[coating_sel.selectedIndex].value;
    var first_date = $('#search_box_date_first').val();
    var last_date = $('#search_box_date_last').val();
    var ah_pulses = $('#search_box_ah').val();
    //var exact_date = $('#search_box_date_last').val();
    $.ajax({
        url : "../SearchPHP/run_search_suggestions.php",
        type: "POST",
        data : {run_number : run_number,
                machine_ID : machine_ID,
                coating_ID : coating_ID,
                ah_pulses  : ah_pulses,
                first_date : first_date,
                last_date  : last_date},
     success: function(data,status, xhr)
     {
        $( "#output" ).replaceWith(data);
     }
    })
} 
function generalInfoRedirect(po_ID){
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {po_ID : po_ID},
     success: function(data,status, xhr)
     {
         var url = "../Printouts/generalinfo.php";
         window.open(url, '_blank');
     }
    })
} 
function trackSheetRedirect(po_ID){
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {po_ID : po_ID},
     success: function(data,status, xhr)
     {
         var url = "../Printouts/tracksheet.php";
         window.open(url, '_blank');
     }
    })
} 