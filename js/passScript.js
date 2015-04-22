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
function showUser(str) {
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
        xmlhttp.open("GET","../SelectPHP/getPos.php?q="+str,true);
        xmlhttp.send();
    }
}
function addPO(){
     var POID       = $('#POID').val();     
     var CID        = $('#CID').val();     
     var rDate      = $('#rDate').val(); 
     var iInspect   = $('#iInspect').val();
     var nrOfLines  = $('#nrOfLines').val();
     var employeeId = $('#employeeId').val();
    // console.log(CID);
    // console.log(POID);
    // console.log(rDate);
    // console.log(iInspect);
    // console.log(nrOfLines);
    // console.log(employeeId);


     $.ajax({
        url : "../InsertPHP/insertNewPO.php",
        type: "POST",
        data : {POID      : POID,
         CID        : CID,
         rDate      : rDate,
         iInspect   : iInspect,
         nrOfLines  : nrOfLines,
         employeeId : employeeId,
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
    },
    error: function (jqXHR, status, errorThrown)
    {
        $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
    xmlhttp.open("GET","../SelectPHP/getPosForToolMenu.php?q="+str,true);
    xmlhttp.send();
    return str;
}
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
   var diameter = $('#diameter').val();  
   var length   = $('#length').val();   
   var POID     = document.getElementById('POID').innerHTML;
     $.ajax({
        url : "../SelectPHP/generatePrice.php",
        type: "POST",
        data : {diameter : diameter,
         length   : length,
         POID     : POID},
         success: function(data,status, xhr)
         {
            $("#status_text").html(data);
         },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
 }
function addTool(){
  var toolID   = $('#tid').val();     
  var lineItem = $('#lineItem').val();     
  var quantity = $('#quantity').val(); 
  var diameter = $('#diameter').val(); 
  var length   = $('#length').val(); 
  var POID     = document.getElementById('POID').innerHTML;
  
  if($('#dblEnd').is(':checked'))
  {
     var dblEnd   = $('#dblEnd').val();
  }
  var price     = document.getElementById('price').value;
  $.ajax({
     url : "../InsertPHP/insertNewToolToPo.php",
     type: "POST",
     data : {toolID  : toolID,
      lineItem : lineItem,
      quantity : quantity,
      diameter : diameter,
      length   : length,
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
     },
     error: function (jqXHR, status, errorThrown)
     {
         $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
       },
       error: function (jqXHR, status, errorThrown)
       {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ');
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
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    });
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
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
         },
        error: function (jqXHR, status, errorThrown)
        {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
 }

 function delPO(){
    var POID = document.getElementById('POID').innerHTML;
    console.log(POID);
    
    $.ajax({
        url : "../DeletePHP/delPOAndTools.php",
        type: "POST",
        data : {POID  : POID,},
        success: function(data,status, xhr)
        {
            //this refreshes the page after delete
            window.location.reload(true);
        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
}
function searchPO() {
    
        // getting the value that user typed
        var searchString    = $("#search_box_PO").val();
        // forming the queryString
        var data            = 'search='+ searchString;
        //console.log(searchString);
        
        // if searchString is not empty
        if(searchString) {
            // ajax call
            $.ajax({
                type: "POST",
                url: "../SearchPHP/do_search.php",
                data: data,
                beforeSend: function(html) { // this happens before actual call
                    $("#results").html(''); 
                    $("#searchresults").show();
                    $(".word").html(searchString);
                },
               success: function(html){ // this happens after we get results
                $("#results").show();
                $("#results").append(html);
            }
        })  
        }
        return false;
    }
    function searchPOCompany() {
        var searchString    = $("#search_box_company").val();
        var data            = 'search='+ searchString;
        if(searchString) {
            $.ajax({
                type: "POST",
                url: "../SearchPHP/do_search_company.php",
                data: data,
                beforeSend: function(html) { 
                    $("#results").html(''); 
                    $("#searchresults").show();
                    $(".word").html(searchString);
                },
               success: function(html){ 
                $("#results").show();
                $("#results").append(html);
            }
        })  
        }
        return false;
    }
    function searchPOEmployee() {
        
        var searchString    = $("#search_box_employee").val();
        var data            = 'search='+ searchString;
       // console.log(searchString);
                if(searchString) {
            $.ajax({
                type: "POST",
                url: "../SearchPHP/do_search_employee.php",
                data: data,
                beforeSend: function(html) {
                    $("#results").html('');
                    $("#searchresults").show();
                    $(".word").html(searchString);
                },
               success: function(html){
                $("#results").show();
                $("#results").append(html);
            }
        })  
        }
        return false;
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
 }
 function changeCustomerPhoneNumber(){
     var CID   = $('#input_CID').val();     
     var cPhone = $('#input_phonenumber').val();     
     console.log(CID);
     console.log(cPhone);
     if(cPhone === ''){return;}
     //make the postdata
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
 }
 function changeCustomerEmail(){
     //get the form values
     var CID   = $('#input_CID').val();     
     var cEmail = $('#input_email').val();     
     //console.log(CID);
     //console.log(cEmail);
     if(cEmail === ''){return;}
     //make the postdata
     
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            //if fail show error and server status
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            //if fail show error and server status
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
 }
 function deleteCustomer(){
     var CID   = $('#input_CID').val();     
     $.ajax({
        url : "../DeletePHP/deleteCustomer.php",
        type: "POST",
        data : {CID : CID},
        success: function(data,status, xhr)
        {
            window.location.reload(true);
            $("#status_text").html(data);
            $("#input_CID").val("");
          // $('#POID').val('');
      },
      error: function (jqXHR, status, errorThrown)
      {
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
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
        machine_run_number = parseInt(machine_run_number) + 1;
            $("#status_text").html(data);
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
    // console.log(runNumber);
    // console.log(lineItem);
    // console.log(number_of_tools);
    // console.log(final_comment);
    // console.log(POID);
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
function addShipDateToPO (line){
   var POID       = document.getElementById('POID').innerHTML;
   var fInspect   = $('#fInspect').val();
   var date       = $('#addShippingDate').val();
  $.ajax({
    url : "../InsertPHP/insertShipDateToPO.php",
    type: "POST",
    data : {POID     : POID,
            fInspect : fInspect,
            date     : date},

        success: function(data,status, xhr)
        {
            alert("Date and final inspection added successfully");
            $("#runTools").html(data);

        },
        error: function (jqXHR, status, errorThrown)
        {
            $("#runTools").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
    })
}
function addCoating (line){
   var coatingType   = $('#coatingType').val();
   var coatingDesc = $('#coatingDesc').val();
  // console.log(coatingType);
  // console.log(coatingDesc);
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
   //console.log(mname);
   //console.log(macro);
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
    //console.log(userID);
    //console.log(password);
  $.ajax({
    url : "../Login/logincheck.php",
    type: "POST",
    data : {userID : userID,
            password : password}
    }).done(function(result){
        $("#txtadd").html(result);
    })
}
/*
    Function that logs the user out.
    Calls a php script that logs you out 
    and then reloads the page so you loose 
    all your privlages
*/
function logout(){
    //console.log('eg er her');
  $.ajax({
    url : "../Login/logout.php",
    type: "POST"
    }).done(function(){
        window.location.reload();
    })
}
































