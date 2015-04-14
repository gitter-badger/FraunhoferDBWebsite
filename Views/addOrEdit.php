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
if($user_sec_lvl < 2){
  echo "<a href='../Login/login.php'>Login Page</a></br>";
  die("You don't have the privlages to view this site.");
}
?>
<html>
<head>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
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
        <h2>Customer info</h2>
        <p class='lead'>Customer menu</p>
        <div class='btn-group'>
          <?php
          if($user_sec_lvl >= 3)
          { 
            echo "<a href='addNewCustomer.php' class='btn btn-primary btn-lg'>Add new Customer</a>";
          }
          ?>
          <div class='btn-group'>
            <a href='viewAllCustomers.php' class='btn btn-success btn-lg' >
              View All Customers
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Employe info</h2>
        <p class='lead'>Employee menu</p>
        <div class='btn-group'>
        <?php
          if($user_sec_lvl >= 3)
          { 
            echo "<a href='addNewEmployee.php' class='btn btn-primary btn-lg'>Add new Employee</a>";
          }
          ?>
          <a href='viewAllEmployees.php' class='btn btn-success btn-lg' >
            View All Employees
          </a>
        </div>
      </div>
    </div>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Machine info</h2>
        <p class='lead'>Machine Menu</p>
        <div class='btn-group'>
        <?php
          if($user_sec_lvl >= 3)
          { 
            echo "<a href='addNewMachine.php' class='btn btn-primary btn-lg' >Add new Machine</a>";
          }
          ?>
          <a href='viewAllMachines.php' class='btn btn-success btn-lg' >
            View All Machines
          </a>
        </div>
      </div>
    </div>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Coating info</h2>
        <p class='lead'>Coating Menu</p>
        <div class='btn-group'>
        <?php
          if($user_sec_lvl >= 3)
          { 
            echo "<a href='addNewCoating.php' class='btn btn-primary btn-lg' >Add new Coating</a>";
          }
          ?>
          <a href='viewAllCoatings.php' class='btn btn-success btn-lg' >
            View All Coatings
          </a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>