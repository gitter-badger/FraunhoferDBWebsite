<!DOCTYPE html>
<?php
include 'connection.php';
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
<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='css/main.css' rel='stylesheet'>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src='js/passScript.js'></script>


</head>
<body>
<div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
        <a href='selection.php' class='navbar-brand'>Selection Page</a>
        <ul class='nav navbar-nav navbar-right'>
          <li><a href='login.php'>Log in or change user</a></li>
          <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
          <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>
        </ul>
    </div>
</div>

    <div class='container'>
     <div class='row well well-lg'>
    <div class='col-md-3'>
    <p >Input the PO number</p>
     <input type="text" name="search" id="search_box_PO" class='search_box'/>
      <button  type='button'  class='btn btn-primary' onclick='searchPO()'>
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
      </button>
    </div>
    <div class='col-md-3'>
    <p >Input the Company Name</p>
    <input type="text" name="search" id="search_box_company" class='search_box'/>
      <button type='button'  class='btn btn-primary' onclick='searchPOCompany()'>
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
      </button>
    </div>
    <div class='col-md-3'>
    <p >Input employee name</p>
        <input type="text" name="search" id="search_box_employee" class='search_box'/>
        <button type='button'  class='btn btn-primary' onclick='searchPOEmployee()'>
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
      </button>
    </div>
</div>  
</div>    
<ul id="results" class="update">
</ul>
 
</div>
   
</body>
</html>