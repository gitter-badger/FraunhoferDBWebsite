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
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <!-- <link href='../css/main.css' rel='stylesheet'> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript" src='../js/searchScript.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <h4>Input info to filter the POS</h4>
      <div class='col-md-3'>
        <p >Input the PO number</p>
        <input type="text" name="po_number" id="search_box_PO" class='search_box' onkeyup='suggestions()'/>
      </div>
      <div class='col-md-3'>
        <p>Customer : </p>
        <select id='customer_select' onchange='suggestions()'>
          <option value="">All customers: </option> 
          <?php
          $sql = "SELECT customer_ID, customer_name 
                  FROM customer;";
          $result = mysqli_query($link, $sql);
          if (!$result) 
          {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result))
          {
            echo '<option value="'.$row['customer_ID'].'">'.$row['customer_name'].'</option>';
          }
          ?>
        </select>
      </div>
      <div class='col-md-3'>
        <p>Receiving date from:</p>
        <input type="date" name="datefirst" id="search_box_date_first" onchange='suggestions()'/>
      </div>
      <div class='col-md-3'>
        <p>Receiving date to:</p>
        <input type="date" name="datelast" id="search_box_date_last" onchange='suggestions()'/>
      </div>
    </div>
    <div id='test'><span></span></div>
    <table class='table table-striped'>
    </table>
    <table id='output'>
    </table>
  </div>   
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>