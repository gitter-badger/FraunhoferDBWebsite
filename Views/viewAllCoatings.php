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
        <h2>Coatings</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Machine ID</th>
            <th>Coating type</th>
            <th>Coating Description</th>
          </tr>
          <?php
            $sql ="SELECT * 
                   FROM coating";
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
  <?php
    if($user_sec_lvl >=3)
    {
      echo"
        <div class='row well well-lg'>
          <div class='col-md-12'>
            <h3>Enter Coating ID to insert or change some values in the table. The coating ID can not be changed!</h3>
            <div class='col-md-3'>
              <h4>Enter the Coating ID Number</h4>
              <input type='number' id='input_coating_ID' /></br>
            </div>
            <div class='col-md-3'>
              <p >Change coating type:</p>
              <input type='text' id='input_type'/>
              <input type='submit' value='Submit' onclick='changeCoatingType()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Change coating description:</p>
              <input type='text' id='input_coating_description'/>
              <input type='submit' value='Submit' onclick='changeCoatingDescription()' class='btn btn-primary'/>
            </div>
            <div class='col-md-3'>
              <p >Delete Coating:
                <button type='button' class='btn btn-default' onclick='deleteCoating()'>
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