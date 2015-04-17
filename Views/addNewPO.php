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
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='../selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='../Login/login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>      </ul>
      </div>
    </div>
    <div class='container'>
      <div class='row well well-lg'>
        <div class='col-md-12'>
          <p>This is the add new po view</p>
          <form onsubmit='return false'>
            <p class='col-md-6'>
              <label for="POID" class='col-md-3'>POID:</label>
              <input type="text" name="POID" id="POID">
            </p>
            <p class='col-md-6'>
              <label for="CID" class ='col-md-3'>Company ID:</label>
              <select id='CID'>
                <option value="">Select a company:</option> 
                  <?php
                  $sql = "SELECT customer_ID, customer_name FROM customer";
                  $result = mysqli_query($link, $sql);

                  if (!$result) {
                  die("Database query failed: " . mysqli_error($link));
                  }
                  while($row = mysqli_fetch_array($result)){
                  echo '<option value="'.$row['CID'].'">'.$row['cName'].'</option>';
                  }
                  ?>
              </select>
            </p>
            <p class='col-md-6'>
              <label for="rDate" class='col-md-3'>Receiving Date:</label>
              <input type="rDate" value="<?php echo date('Y-m-d'); ?>" name='rDate' id='rDate'>
            </p>
            <p class='col-md-6'>
              <label for="iInspect" class='col-md-3'>Initial Inspection:</label>
              <input type="text" name="iInspect" id="iInspect">
            </p>
            <p class='col-md-6'>
              <label for="nrOfLines" class='col-md-3'>Number of Lines:</label>
              <input type="number" name='nrOfLines' id='nrOfLines'>
            </p>
            <p class='col-md-6'>
              <label for="employeeId" class='col-md-3'>Employee ID:</label>
              <input type="number" name='employeeId' id='employeeId'>
            </p>
            <input class='col-md-offset-4' type="submit" id="btn_submit" onclick='addPO()' value="Add PO">
          </form>
          <br/>
          <form class='col-md-offset-10' action="addTools2.php">
            <input type="submit" value="Add Tools to PO!">
          </form>
        </div>
      </div>
    </div>
  </body>
  </html>
