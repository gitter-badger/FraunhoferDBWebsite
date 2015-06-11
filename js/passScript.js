function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('ePass');
    var pass2 = document.getElementById('ePassAgain');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and informxw
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}  
function addOldRun(){
     var POID    = document.getElementById('POID').innerHTML;
     //this fetches the dropdownlist 
     var e       = document.getElementById("runsel");
     //this chooses the selected item from the dropdown list
     var old_run = e.options[e.selectedIndex].value;
     $.ajax({
        url : "../InsertPHP/addOldRun.php",
        type: "POST",
        data : {
                    POID    : POID,
                    old_run : old_run,
                },
     success: function(data,status, xhr)
     {
        $("#status_text").html(data);
        // if it is a success we want to refresh the PORuns list
        showPORuns();
     },
    error: function (jqXHR, status, errorThrown)
    {
        $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
    }
    })
}
function setSessionID(){
     //this fetches the dropdownlist 
    var e       = document.getElementById("packingsel");
    //this chooses the selected item from the dropdown list
    var po_ID = e.options[e.selectedIndex].value;
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {
                    po_ID : po_ID,
               },
     success: function(data,status, xhr)
     {
        $("#status_text").html(data);
     },
    })
}
function addPO(){
    var POID          = $('#POID').val();     
    var CID           = $('#CID').val();     
    var rDate         = $('#rDate').val(); 
    var iInspect      = $('#iInspect').val();
    var nrOfLines     = $('#nrOfLines').val();
    var employeeId    = $('#employeeId').val();
    var e             = document.getElementById("shipping_sel");
    var shipping_info = e.options[e.selectedIndex].value;
    $.ajax({
       url : "../InsertPHP/insertNewPO.php",
       type: "POST",
       data : {POID          : POID,
               CID           : CID,
               rDate         : rDate,
               iInspect      : iInspect,
               nrOfLines     : nrOfLines,
               employeeId    : employeeId,
               shipping_info : shipping_info
    },
    success: function(data,status, xhr)
    {
       $("#status_text").html(data);
       $('#POID').val('');
       $('#CID').val('');
       $('#rDate').val('');
       $('#iInspect').val('');
       $('#nrOfLines').val('');
       $('#employeeId').val('');
       setSessionIDAfterAddingPO(POID);
    }
 })
}
function showTools(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    setSessionIDPrint(str);
    displayHelper();
    xmlhttp.open("GET","../SelectPHP/getPosForToolMenu.php?q="+str,true);
    xmlhttp.send();


    return str;
}
}
function setSessionIDPrint(po_ID){
    $.ajax({
        url : "../UpdatePHP/setSessionID.php",
        type: "POST",
        data : {po_ID : po_ID},
    })
} 
function showToolsPrint(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getPOForPrinting.php?q="+str,true);
    xmlhttp.send();
    return str;
}
}
function showTrackPrint(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getPOForPrintingTrack.php?q="+str,true);
    xmlhttp.send();
    return str;
}
}

function showToolsTrack(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getPOForTrackSheet.php?q="+str,true);
    xmlhttp.send();
    return str;
}
}
function showPOTools() {
    var str = document.getElementById('POID').innerHTML;
    console.log(str);
    if (str == "") {
        document.getElementById("txtAdd").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtAdd").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getToolsForToolOverView.php?q="+str,true);
    xmlhttp.send();
    return str;
}
}


function showPORuns() {
    var str = document.getElementById('POID').innerHTML;
    if (str == "") {
        document.getElementById("txtAddRun").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtAddRun").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getRunsForPO.php?q="+str,true);
    xmlhttp.send();
    return str;
}
}
function showRunTools() {
    var str = document.getElementById('POID').innerHTML;
    if (str == "") {
        document.getElementById("txtAddToolToRun").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtAddToolToRun").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../SelectPHP/getToolsForRun.php?q="+str,true);
    xmlhttp.send();

    return str;
}
}     
function generatePrice(){
   var diameter         = $('#diameter').val();  
   var length           = $('#length').val();   
   var POID             = document.getElementById('POID').innerHTML;
   var coating_dropdown = document.getElementById("coating_sel");
   var coating_ID       = coating_dropdown.options[coating_dropdown.selectedIndex].value;
     $.ajax({
        url : "../SelectPHP/generatePrice.php",
        type: "POST",
        data : {diameter : diameter,
         length   : length,
         POID     : POID},
         success: function(data,status, xhr)
         {
            if(coating_ID === "DLC")
            {
                data = data * 2;
            }
            // output the data recieved from the php file into the price field.
            document.getElementById('price').value = data;
         }
    })
 }
function displayHelper(){
     $.ajax({
        url : "../SelectPHP/displayHelper.php",
        type: "GET",
         success: function(data,status, xhr)
         {
            $("#displayHelper").html(data);
         }
    })
}
function addTool(){
  var toolID     = $('#tid').val();     
  var lineItem   = $('#lineItem').val();     
  var quantity   = $('#quantity').val(); 
  var diameter   = $('#diameter').val(); 
  var length     = $('#length').val(); 
  var POID       = document.getElementById('POID').innerHTML;
  var e          = document.getElementById('coating_sel');
  var coating_ID = e.options[e.selectedIndex].value;

  if($('#dblEnd').is(':checked'))
  {
     var dblEnd   = $('#dblEnd').val();
  }
  var price     = document.getElementById('price').value;
  $.ajax({
     url : "../InsertPHP/insertNewToolToPo.php",
     type: "POST",
     data : {toolID     : toolID,
             lineItem   : lineItem,
             coating_ID : coating_ID,
             quantity   : quantity,
             diameter   : diameter,
             length     : length,
             price      : price,
             dblEnd     : dblEnd,
             POID       : POID
      },
      success: function(data,status, xhr)
      {
        lineItem = parseInt(lineItem) + 1;
        $("#status_text").html(data);
        $('#toolID').val('');
        $('#lineItem').val(lineItem);
        $('#quantity').val('');
        $('#POID').val('');
        showPOTools();
     }
 })
}
function addToolOdd(){
  var toolID     = $('#tidOdd').val();     
  var lineItem   = $('#lineItemOdd').val();     
  var quantity   = $('#quantityOdd').val(); 
  var POID       = document.getElementById('POID').innerHTML;
  var e          = document.getElementById('coating_sel_odd');
  var coating_ID = e.options[e.selectedIndex].value; 
  if($('#dblEndOdd').is(':checked'))
  {
     var dblEnd   = $('#dblEndOdd').val();
  }
  var price = document.getElementById('priceOdd').value;
  $.ajax({
     url : "../InsertPHP/insertNewToolToPo.php",
     type: "POST",
     data : {   toolID  : toolID,
             coating_ID : coating_ID,
               lineItem : lineItem,
               quantity : quantity,
               price    : price,
               dblEnd   : dblEnd,
               POID     : POID},
      success: function(data,status, xhr)
      {
         lineItem = parseInt(lineItem) + 1;
         $("#status_text").html(data);
         $('#toolID').val('');
         $('#lineItem').val(lineItem);
         $('#quantity').val('');
         $('#POID').val('');
         showPOTools();
     }
 })
}
function addCustomer(){
     var cName    = $('#cName').val();     
     var cAddress = $('#cAddress').val();     
     var cEmail   = $('#cEmail').val(); 
     var cPhone   = $('#cPhone').val();
     var cFax     = $('#cFax').val();
     var cContact = $('#cContact').val();
     var cNotes   = $('#cNotes').val();
     $.ajax({
        url : "../InsertPHP/insertNewCustomer.php",
        type: "POST",
        data : {cName   : cName,
         cAddress : cAddress,
         cEmail   : cEmail,
         cPhone   : cPhone,
         cFax     : cFax,
         cContact : cContact,
         cNotes   : cNotes},

         success: function(data,status, xhr)
         {
           $('#cName').val('');
           $('#cAddress').val('');
           $('#cEmail').val('');
           $('#cPhone').val('');
           $('#cFax').val('');
           $('#cContact').val('');
           $('#cNotes').val('');
       }
    })
}
function addEmployee(){
     var eName        = $('#eName').val();     
     var ePhoneNumber = $('#ePhoneNumber').val();     
     var eEmail       = $('#eEmail').val(); 
     var ePass        = $('#ePass').val();
     var ePassAgain   = $('#ePassAgain').val();
     var sec_lvl      = $('#sec_lvl').val();
     $.ajax({
        url : "../InsertPHP/insertNewEmployee.php",
        type: "POST",
        data : {eName : eName,
         ePhoneNumber : ePhoneNumber,
         eEmail       : eEmail,
         ePass        : ePass,
         sec_lvl      : sec_lvl,
         ePassAgain   : ePassAgain},

         success: function(data,status, xhr)
         {
             //alert("Employee added");

            $("#status_text").html(data);
            $('#eName').val('');
            $('#ePhoneNumber').val('');
            $('#eEmail').val('');
            $('#ePass').val('');
            $('#ePassAgain').val('');
        }
    })
 }
function delTool(line){
    var POID = document.getElementById('POID').innerHTML;
     $.ajax({
        url : "../DeletePHP/deleteToolFromPO.php",
        type: "POST",
        data : {POID  : POID,
         line : line},
         success: function(data,status, xhr)
         {
            $("#status_text").html(data);
            //alert("Tool deleted successfully");
        }
    })
 }
function delRun(line){
    var POID = document.getElementById('POID').innerHTML;
     $.ajax({
        url : "../DeletePHP/deleteRun.php",
        type: "POST",
        data : {POID  : POID,
                line : line},
         success: function(data,status, xhr)
         {
            $("#status_text").html(data);
            //alert("Run deleted successfully");
        }
    })
 }
function delRunTool(lineitem, run_number){
    var POID = document.getElementById('POID').innerHTML;
     $.ajax({
        url : "../DeletePHP/deleteRunTool.php",
        type: "POST",
        data : {POID       : POID,
                lineitem   : lineitem,
                run_number : run_number},
         success: function(data,status, xhr)
         {
            showPORuns();
            $("#status_text").html(data);
         }
    })
 }
function delPO(){
     //this fetches the dropdownlist 
    var e       = document.getElementById("po_sel");
     //this chooses the selected item from the dropdown list
    var po_ID = e.options[e.selectedIndex].value; 
    
    $.ajax({
        url : "../DeletePHP/delPOAndTools.php",
        type: "POST",
        data : {po_ID  : po_ID,},
        success: function(data,status, xhr)
        {
            //this refreshes the page after delete
            window.location.reload(true);
        }
    })
}
function changeCustomerAddress(){
    var CID   = $('#input_CID').val();     
    var cAddress = $('#input_address').val();     
    if(cAddress === ''){return;}
    $.ajax({
        url : "../UpdatePHP/updateCustomerAddress.php",
        type: "POST",
        data : {CID : CID,
        cAddress : cAddress},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_address").val("");
        }
    })
}
function changeCustomerPhoneNumber(){
    var CID   = $('#input_CID').val();     
    var cPhone = $('#input_phonenumber').val();     
    if(cPhone === ''){return;}
    $.ajax({
        url : "../UpdatePHP/updateCustomerPhone.php",
        type: "POST",
        data : {CID : CID,
                cPhone : cPhone},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_phonenumber").val("");
          // $('#POID').val('');
        }
    })
 }
function changeCustomerEmail(){
    //get the form values
    var CID   = $('#input_CID').val();     
    var cEmail = $('#input_email').val();      
    if(cEmail === ''){return;}     
    $.ajax({
        url : "../UpdatePHP/updateCustomerEmail.php",
        type: "POST",
        data : {CID : CID,
                cEmail : cEmail},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            //if success then just output the text to the status div then clear the form inputs to prepare for new data
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_email").val("");
          // $('#POID').val('');
        }
    })
}
function changeCustomerFax(){
    //get the form values
    var CID   = $('#input_CID').val();     
    var cFax = $('#input_faxnumber').val();
    if(cFax === '')
    {
       return;
    }     
     //console.log(CID);
    // console.log(cFax);
    $.ajax({
        url : "../UpdatePHP/updateCustomerFax.php",
        type: "POST",
        data : {CID : CID,
                cFax : cFax},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_faxnumber").val("");
         // $('#POID').val('');
        }
    })
}
function changeCustomerNotes(){
    var CID   = $('#input_CID').val();     
    var cNotes = $('#input_notes').val();
    if(cNotes === '')
    {
        return;
    }     
    $.ajax({
        url : "../UpdatePHP/updateCustomerNotes.php",
        type: "POST",
        data : {CID : CID,
        cNotes : cNotes},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_notes").val("");
          // $('#POID').val('');
        }
    })
}
function changeCustomerContact(){
    var CID   = $('#input_CID').val();     
    var cContact = $('#input_contact').val();
    if(cContact === '')
    {
        return;
    }     
    $.ajax({
        url : "../UpdatePHP/updateCustomerContact.php",
        type: "POST",
        data : {CID : CID,
        cContact : cContact},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
            $("#input_contact").val("");
          // $('#POID').val('');
        }
    })
}
function deleteCustomer(){
    var customer_ID = $('#input_CID').val();     
    console.log(customer_ID);
    $.ajax({
        url : "../DeletePHP/deleteCustomer.php",
        type: "POST",
        data : {customer_ID : customer_ID},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
        }
    })
}
function addRun(){
     var runDate             = $('#runDate').val();     
     var rCoating            = $('#coatingID').val();     
     var machine_run_number  = $('#machine_run_number').val(); 
     var ah_pulses           = $('#ah_pulses').val(); 
     var machine             = $('#machineID').val(); 
     var rcomments           = $('#rcomments').val();
     var run_on_this_PO      = $('#run_number').val();
     var POID                = document.getElementById('POID').innerHTML;
   $.ajax({
    url : "../InsertPHP/insertNewRunToTrackSheet.php",
    type: "POST",
    data : {runDate           : runDate,
            rCoating           : rCoating,
            POID               : POID,
            machine_run_number : machine_run_number,
            ah_pulses          : ah_pulses,
            machine            : machine,
            run_on_this_PO     : run_on_this_PO,
            rcomments          :rcomments},
     success: function(data,status, xhr)
     {
            // increment the run number and update it on the html view
            // run_on_this_PO = parseInt(run_on_this_PO) + 1;
            $('#run_number').val(run_on_this_PO);

            $("#status_text").html(data);
            // refresh the table to show the newly inserted run.
            showPORuns();

      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
}
/*
    Adds one line item to a run
    You can add multiple lines of the
    same item here so you can add more than
    one line of tools to every run
*/
function addLineItemToRun(){
     var lineItem        = $('#lineItem').val();     
     var number_of_tools = $('#number_of_tools').val();     
     var runNumber       = $('#runNumber').val(); 
     var final_comment   = $('#final_comment').val();
     var POID            = document.getElementById('POID').innerHTML;
   $.ajax({
    url : "../InsertPHP/insertLineItemtoRun.php",
    type: "POST",
    data : {lineItem       : lineItem,
            number_of_tools : number_of_tools,
            runNumber       : runNumber,
            POID            : POID,
            final_comment   : final_comment,
 },

        success: function(data,status, xhr)
        {   
            $("#status_text2").html(data);
            showRunTools();

        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#runTools").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
}
/*
    Adds a final inspection comment
    and a shipping date to the chosen PO
*/
function confirmPO(){
   var POID     = document.getElementById('POID').innerHTML;
   var date     = $('#addShippingDate').val();
  $.ajax({
    url : "../InsertPHP/confirmTrackSheet.php",
    type: "POST",
    data : {POID     : POID,
            fInspect : fInspect,
            date     : date},
        success: function(data,status, xhr)
        {
            if(data.indexOf("Error") > -1){
               alert(data);
            } else if(data.indexOf("missing") > -1){
                var r = confirm(data);
                if(r == true)
                {
                    addShipDateToPO(POID, fInspect, date);
                }
            }else if(data.indexOf("assigned") > -1){
                var r = confirm(data);
                if(r == true)
                {
                    addShipDateToPO(POID, fInspect, date);
                }
            }else{
                addShipDateToPO(POID, fInspect, date);
            }
        }
    })
}
function addShipDateToPO (POID, fInspect, date){
  $.ajax({
    url : "../InsertPHP/insertShipDateToPO.php",
    type: "POST",
    data : {POID     : POID,
            fInspect : fInspect,
            date     : date},
        success: function(data,status, xhr)
        {
            if(data.indexOf("Error") > -1){
                console.log(data)
            }else{
                window.location.reload(true);
            }
        },
    })
}
function addCoating (line){
   var coatingType   = $('#coatingType').val();
   var coatingDesc = $('#coatingDesc').val();
  $.ajax({
    url : "../InsertPHP/insertNewCoating.php",
    type: "POST",
    data : {coatingType : coatingType,
            coatingDesc : coatingDesc},
        success: function(data,status, xhr)
        {
            $("#errormsg").html('you added ' + coatingType + ' to the database');
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#errormsg").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
}
function addNewMachine (line){
   var mname   = $('#mname').val();
   var macro = $('#macro').val();
  $.ajax({
    url : "../InsertPHP/insertNewMachine.php",
    type: "POST",
    data : {mname : mname,
            macro : macro},
        success: function(data,status, xhr)
        {
            $("#errormsg").html('you added to the database');
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#errormsg").html('there was an error');
        }
    })
}
/*
    Function that checks if your password matches your 
    username.
*/
function authenticate(){
    var userID   = $('#userID').val();
    var password   = $('#password').val();
  $.ajax({
    url : "../Login/logincheck.php",
    type: "POST",
    data : {userID : userID,
            password : password},
    success: function(data, status, xhr)
    {
        /*
            checks if the data recieved from the php file
            contains the string "error".

            data.indexOf("error") returns -1 only if the string
            is not found, so if the string is found it will return
            a number larger than -1 and we move to the selection site.
            The php file takes care of logging in or logging off the current user if he tries to log 
            in with wrong information, this is done for security reasons
        */
        if(data.indexOf("error") > -1)
        {
            alert("Please enter the right information");

        }else{
            window.location = "../Selection.php";
        }
    }
    })
}
function logout(){
  $.ajax({
    url : "../Login/logout.php",
    type: "POST"
    }).done(function(){
        // redirect the user to the login page
        // this is done so you loose access to the site you are at
        // when you log out.
        window.location = "../Login/login.php";
    })
}
function changeCoatingType(){
    var coating_ID   = $('#input_coating_ID').val();     
    var coating_type = $('#input_type').val();     
    $.ajax({
        url : "../UpdatePHP/updateCoatingType.php",
        type: "POST",
        data : {coating_ID : coating_ID,
                coating_type : coating_type},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_coating_ID").val("");
            $("#input_type").val("");
        }
    })
}
function changeCoatingDescription(){
    var coating_ID          = $('#input_coating_ID').val();     
    var coating_description = $('#input_coating_description').val();     
    $.ajax({
        url : "../UpdatePHP/updateCoatingDescription.php",
        type: "POST",
        data : {coating_ID : coating_ID,
                coating_description : coating_description},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_coating_ID").val("");
            $("#input_coating_description").val("");
        }
    })
}
function deleteCoating(){
    var coating_ID   = $('#input_coating_ID').val();     
    $.ajax({
        url : "../DeletePHP/deleteCoating.php",
        type: "POST",
        data : {coating_ID : coating_ID},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_coating_ID").val("");
        }
    })
}
function deleteMachine(){
    var machine_ID   = $('#input_machine_ID').val();     
    $.ajax({
        url : "../DeletePHP/deleteMachine.php",
        type: "POST",
        data : {machine_ID : machine_ID},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_machine_ID").val("");
        }
    })
}
function changeMachineName(){
    var machine_ID   = $('#input_machine_ID').val();     
    var machine_name = $('#input_machine_name').val();     
    $.ajax({
        url : "../UpdatePHP/updateMachineName.php",
        type: "POST",
        data : {machine_ID : machine_ID,
                machine_name : machine_name},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_machine_ID").val("");
            $("#input_machine_name").val("");
        }
    })
}
function changeMachineComment(){
    var machine_ID      = $('#input_machine_ID').val();     
    var machine_comment = $('#input_machine_comment').val();     
    $.ajax({
        url : "../UpdatePHP/updateMachineComment.php",
        type: "POST",
        data : {machine_ID : machine_ID,
                machine_comment : machine_comment},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_machine_ID").val("");
            $("#input_machine_comment").val("");
        }
    })
}
function changeMachineAcronym(){
    var machine_ID      = $('#input_machine_ID').val();     
    var machine_acronym = $('#input_machine_acronym').val();     
    $.ajax({
        url : "../UpdatePHP/updateMachineAcronym.php",
        type: "POST",
        data : {machine_ID : machine_ID,
                machine_acronym : machine_acronym},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_machine_ID").val("");
            $("#input_machine_acronym").val("");
        }
    })
}
function changeEmployeeName(){
    var employee_ID   = $('#input_employee_ID').val();     
    var employee_name = $('#input_employee_name').val();    
    $.ajax({
        url : "../UpdatePHP/updateEmployeeName.php",
        type: "POST",
        data : {employee_ID : employee_ID,
                employee_name : employee_name},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_employee_ID").val("");
            $("#input_employee_name").val("");
        }
    })
}
function changeEmployeeEmail(){
    var employee_ID    = $('#input_employee_ID').val();     
    var employee_email = $('#input_employee_email').val();     
    $.ajax({
        url : "../UpdatePHP/updateEmployeeEmail.php",
        type: "POST",
        data : {employee_ID : employee_ID,
                employee_email : employee_email},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_employee_ID").val("");
            $("#input_employee_email").val("");
        }
    })
}
function changeEmployeePhone(){
    var employee_ID    = $('#input_employee_ID').val();     
    var employee_phone = $('#input_employee_phone').val();     
    $.ajax({
        url : "../UpdatePHP/updateEmployeePhone.php",
        type: "POST",
        data : {employee_ID : employee_ID,
                employee_phone : employee_phone},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_employee_ID").val("");
            $("#input_employee_phone").val("");
        }
    })
}
function changeEmployeeSecurityLevel(){
    var employee_ID    = $('#input_employee_ID').val();     
    var security_level = $('#input_security_level').val();     
    $.ajax({
        url : "../UpdatePHP/updateEmployeeSecurityLevel.php",
        type: "POST",
        data : {employee_ID : employee_ID,
                security_level : security_level},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_employee_ID").val("");
            $("#input_security_level").val("");
        }
    })
}
function deleteEmployee(){
    var employee_ID   = $('#input_employee_ID').val();     
    $.ajax({
        url : "../DeletePHP/deleteEmployee.php",
        type: "POST",
        data : {employee_ID : employee_ID},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_employee_ID").val("");
        }
    })
}
function setSessionIDAfterAddingPO(po_ID){
    $.ajax({
        url : "../UpdatePHP/setSessionIDWithPONumber.php",
        type: "GET",
        data : {
                    po_ID : po_ID,
               },
     success: function(data,status, xhr)
     {
        $("#test").html(data);
     },
    })
}
function addFeedback(){
    var name    = $('#name').val();
    var comment = $('#comment').val();
    $.ajax({
        url : "../InsertPHP/addFeedback.php",
        type: "POST",
        data : {
                     name : name,
                     comment : comment},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function storePackingList(po_ID){
    var comment = $('#packing_list_comment').val();
    $.ajax({
        url : "../InsertPHP/addPackingList.php",
        type: "POST",
        data : {
                 po_ID : po_ID,
                 comment : comment}
        })
}

function changeLineitemQuantity(po_ID){
    var line     = $('#line').val();
    var quantity = $('#input_quantity').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemQuantity.php",
        type: "POST",
        data : { po_ID    : po_ID,
                 line     : line,
                 quantity : quantity},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changeLineitemPrice(po_ID){
    var line  = $('#line').val();
    var price = $('#input_price').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemPrice.php",
        type: "POST",
        data : { po_ID : po_ID,
                 line  : line,
                 price : price},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changeLineitemTool(po_ID){
    var line = $('#line').val();
    var tool = $('#input_tool').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemTool.php",
        type: "POST",
        data : { po_ID    : po_ID,
                 line     : line,
                 tool : tool},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changeLineitemDiameter(po_ID){
    var line     = $('#line').val();
    var diameter = $('#input_diameter').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemDiameter.php",
        type: "POST",
        data : { po_ID    : po_ID,
                 line     : line,
                 diameter : diameter},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changeLineitemLength(po_ID){
    var line   = $('#line').val();
    var length = $('#input_length').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemLength.php",
        type: "POST",
        data : { po_ID  : po_ID,
                 line   : line,
                 length : length},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changeLineitemDoubleEnd(po_ID){
    var line = $('#line').val();
    var end  = $('#input_end').val();
    $.ajax({
        url : "../UpdatePHP/updateLineitemEnd.php",
        type: "POST",
        data : { po_ID : po_ID,
                 line  : line,
                 end   : end},
     success: function(data,status, xhr)
     {
        if(data.indexOf("Error") > -1)
        {
            alert("Value must be either 1 or 0");
        }else{
            window.location.reload(true);
        }
     }
    })
}
function deleteLineitem(POID){
    var line = $('#line').val();
    $.ajax({
        url : "../DeletePHP/deleteToolFromPO.php",
        type: "POST",
        data : {POID  : POID,
                line : line},
         success: function(data,status, xhr)
         {
            window.location.reload(true);
            $("#status_text").html(data);
            //alert("Tool deleted successfully");
        }
    })
 }
 function updateRunToolComment(lineitem_ID, run_ID){
    $('textarea').select(); //select text inside
    comment = window.getSelection().toString();
    $.ajax({
        url : "../UpdatePHP/updateRunToolComment.php",
        type: "POST",
        data : {lineitem_ID  : lineitem_ID,
                run_ID : run_ID,
                comment : comment},
         success: function(data,status, xhr)
         {
            showRunTools();
         }
    })
 }
 function updateRunComment(run_ID){
    $('textarea').select(); //select text inside
    comment = window.getSelection().toString();
    $.ajax({
        url : "../UpdatePHP/updateRunComment.php",
        type: "POST",
        data : {run_ID : run_ID,
                comment : comment},
     success: function(data,status, xhr)
     {
        showPORuns();
     }
    })
}
function changePOReceivingDate(po_ID){
    var receiving_date = $('#input_date').val();
    $.ajax({
        url : "../UpdatePHP/updatePOReceivingDate.php",
        type: "POST",
        data : { po_ID : po_ID,
                 receiving_date  : receiving_date},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changePOInitialInspection(po_ID){
    var initial_inspection = $('#input_inital_inspect').val();
    console.log(initial_inspection);
    $.ajax({
        url : "../UpdatePHP/updatePOInitialInspection.php",
        type: "POST",
        data : { po_ID : po_ID,
                 initial_inspection  : initial_inspection},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changePONumberOfLines(po_ID){
    var number_of_lines = $('#input_number_of_lines').val();
    $.ajax({
        url : "../UpdatePHP/updatePONumberOfLines.php",
        type: "POST",
        data : { po_ID : po_ID,
                 number_of_lines  : number_of_lines},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}
function changePOShippingInfo(po_ID){
    var e             = document.getElementById("shipping_sel");
    var shipping_info = e.options[e.selectedIndex].value;
    $.ajax({
        url : "../UpdatePHP/updatePOShippingInfo.php",
        type: "POST",
        data : { po_ID : po_ID,
                 shipping_info  : shipping_info},
     success: function(data,status, xhr)
     {
        window.location.reload(true);
     }
    })
}





























