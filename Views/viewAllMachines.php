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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src='../js/bootstrap.min.js'></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
<body>
<?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Machines</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Machine ID</th>
            <th>Machine Name</th>
            <th>Machine Acronym</th>
            <th>Comment</th>
          </tr>
          <?php
            $sql ="SELECT * 
                   FROM machine";
            $result = mysqli_query($link, $sql);
            if (!$result){
             die("Database query failed: " . mysql_error());
           }
           while($row = mysqli_fetch_array($result)){
            echo "<tr>".
            "<td>".$row[0]."</td>".
            "<td>".$row[1]."</td>".
            "<td>".$row[2]."</td>".
            "<td>".$row[3]."</td>".
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
            <h3>Enter Machine ID to insert or change some values in the table. The Machine ID can not be changed!</h3>
            <div class='col-md-3'>
              <h4>Enter the Machine ID</h4>
              <input type='number' id='input_machine_ID' /></br>
            </div>
            <div class='col-md-3'>
              <p >Change machine name:</p>
              <input type='text' id='input_machine_name'/>
              <input type='submit' value='Submit' onclick='changeMachineName()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change machine comment:</p>
              <input type='text' id='input_machine_comment'/>
              <input type='submit' value='Submit' onclick='changeMachineComment()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change machine acronym:</p>
              <input type='text' id='input_machine_acronym'/>
              <input type='submit' value='Submit' onclick='changeMachineAcronym()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Delete machine:
                <button type='button' class='btn btn-default' onclick='deleteMachine()'>
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