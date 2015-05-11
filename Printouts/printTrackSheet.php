<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT sec_lvl
           FROM Employees
           WHERE ename = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/print.css' rel='stylesheet'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script>
  $("button").click(function(){
    $("p").toggle();
  });
  </script>
  <style type="text/css" media="print">
  table { page-break-inside:auto; }
  tr    { page-break-inside:auto; }
  @media print{@page {size: landscape}}
  </style>


</head>
<body style='font-size:9px'>
  <div class='col-md-10 col-md-offset-1'>
    <h5>Customer product track for coating</h5>
    <div>
      <form>
        <label>POID: <select name='POS' onchange='showTrackPrint(this.value)'>
          <option name='po'value''>Select a PO#: </option>
          <?php 
          $sql = "SELECT po_ID, po_number FROM pos";
          $result = mysqli_query($link, $sql);
          while($row = mysqli_fetch_array($result)){
           echo '<option value="'.$row[0].'">'.$row[1].'</option>';
         }   
         echo "</select></label></form>";
         ?>
       </div>
       <br><div id="txtHint"><b>PO info will be listed here...</b></div>
     </div>
   </body>
   </html>
