<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT security_level
           FROM employee
           WHERE employee_name = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
if($user_sec_lvl < 2){
  echo "<a href='../Login/login.php'>Login Page</a></br>";
  die("You don't have the privlages to view this site.");
}
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <script src='../js/bootstrap.min.js'></script>

</head>
<body>
<?php include '../header.php'; ?>
    <div class='container'>
     <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Choose the right PO number</h2>
        <form><select name='POS' id='po_sel'onchange='showTools(this.value);showPOTools()'>
          <option value''>Select a PO#: </option>
          <?php 
          $sql = "SELECT po_ID, po_number FROM pos";
          $result = mysqli_query($link, $sql);
          while($row = mysqli_fetch_array($result)){
           echo '<option value="'.$row[0].'">'.$row[1].'</option>';
         } 
         echo "</select></form>";
         ?>

         <br><div id="txtHint"><b>PO info will be listed here...</b></div>
       </div>
     </div>
     <div class='row well well-lg'>
       <div class='col-md-12'>
        <p class='col-md-4'>
          <input type='submit' class='btn btn-danger' name='addTool' value='Delete this PO?' onclick='delPO()'>
        </p>
      </div>
    </div>
  </div>
</body>
</html>