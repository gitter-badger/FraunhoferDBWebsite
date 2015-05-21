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
// if the users security level is to low he can access this page.
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
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <p>This is the add new po view</p>
        <p class='col-md-6'>
          <label for="POID" class='col-md-3'>POID:</label>
          <input type="text" name="POID" id="POID">
        </p>
        <p class='col-md-6'>
          <label for="CID" class ='col-md-3'>Company:</label>
          <select id='CID'>
            <option value="">Select a company:</option> 
            <?php
              $sql = "SELECT customer_ID, customer_name 
                      FROM customer";
              $result = mysqli_query($link, $sql);

              if (!$result) {
                die("Database query failed: " . mysqli_error($link));
              }
              while($row = mysqli_fetch_array($result)){
                echo '<option value="'.$row['customer_ID'].'">'.$row['customer_name'].'</option>';
              }
            ?>
          </select>
        </p>
        <p class='col-md-6'>
          <label for="employeeId" class ='col-md-3'>Employee:</label>
          <select id='employeeId'>
            <option value="">Select a employee:</option> 
            <?php
            $sql = "SELECT employee_ID, employee_name 
                    FROM employee";
            $result = mysqli_query($link, $sql);

            if (!$result) {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result)){
              echo '<option value="'.$row['employee_ID'].'">'.$row['employee_name'].'</option>';
            }
            ?>
          </select>
        </p>
        <p class='col-md-6'>
          <label for="rDate" class='col-md-3'>Receiving Date:</label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>" name='rDate' id='rDate'>
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
          <label for="shipping_sel" class='col-md-3'>Shipping info:</label>
          <select id='shipping_sel'>
            <option value='Ground'>Ground</option>
            <option value='3 day'>3 day</option>
            <option value='2 day'>2 day</option>
            <option value='next day'>Next day</option>
            <option value='fedex'>Fedex</option>
            <option value='other'>Other</option>
          </select>
        </p>
        <input class='col-md-offset-4' type="submit" id="btn_submit" onclick='addPO()' value="Add PO">
        <br/>
        <div class='col-md-offset-10'>
          <button type='button' onclick="location.href='addTools2.php'">Add tools to PO</a></button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
