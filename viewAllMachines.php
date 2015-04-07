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

  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script type="text/javascript" src='js/passScript.js'></script>
</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>      </ul>
      </div>
  </div>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Here is a list of all our Machines</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Machine ID</th>
            <th>Machine Name</th>
            <th>Machine Acronym</th>
          </tr>
          <?php
          $sql ="SELECT * 
          FROM Machine";
          $result = mysqli_query($link, $sql);
          if (!$result){
           die("Database query failed: " . mysql_error());
         }
         while($row = mysqli_fetch_array($result)){
          echo "<tr>".
          "<td>".$row[0]."</td>".
          "<td>".$row[1]."</td>".
          "<td>".$row[2]."</td>".
          "</tr>";

        }


        ?>
      </table>
    </div>
  </div>
</div>
</body>
</html>