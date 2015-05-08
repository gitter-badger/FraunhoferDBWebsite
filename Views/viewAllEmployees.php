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
  <link href='../css/main.css' rel='stylesheet'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
<body>
<?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Here is a list of all our Employees</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Security level</th>
          </tr>
          <?php
          $sql ="SELECT employee_ID, employee_name, employee_email, employee_phone, security_level 
                 FROM employee";
          $result = mysqli_query($link, $sql);
          if (!$result){
           die("Database query failed: " . mysql_error());
         }
         while($row = mysqli_fetch_array($result)){
          echo "<tr>".
          "<td>".$row[0]."</td>".
          "<td>".$row[1]."</td>".
          "<td>"."<a href='mailto:$row[2]'>".$row[2]."</a>".
          "</td>".
          "<td>".$row[3]."</td>".
          "<td>".$row[4]."</td>".
          "</tr>";

        }


        ?>
      </table>
    </div>
  </div>
    <?php
    if($user_sec_lvl >=3)
    {
      echo"
        <div class='row well well-lg'>
          <div class='col-md-12'>
            <h2>Enter Employee ID to insert or change some values in the table. The Employee ID can not be changed!</h2>
            <div class='col-md-3'>
              <h3 >Enter the Employee ID</h3>
              <input type='number' id='input_employee_ID' /></br>
            </div>
            <div class='col-md-3'>
              <p >Change Employee name:</p>
              <input type='text' id='input_employee_name'/>
              <input type='submit' value='Submit' onclick='changeEmployeeName()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change Employee email:</p>
              <input type='text' id='input_employee_email'/>
              <input type='submit' value='Submit' onclick='changeEmployeeEmail()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change Employee phone:</p>
              <input type='text' id='input_employee_phone'/>
              <input type='submit' value='Submit' onclick='changeEmployeePhone()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change Employee security level:</p>
              <input type='text' id='input_security_level'/>
              <input type='submit' value='Submit' onclick='changeEmployeeSecurityLevel()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Delete Employee:
                <button type='button' class='btn btn-default' onclick='deleteEmployee()'>
                  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                </button>
              </p>
            </div>
          </div>
        </div>";
    }
  ?>
</div>
</body>
</html>