<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
$poid = mysqli_real_escape_string($link, $_POST['POID']);
//$_SESSION["POID"] = $poid;
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
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
  <body>
    <div class="col-md-12">
      <img src="../images/iso.jpg"             alt="ISO logo"        style="float:left; width:150px; height:auto; margin-top:10px; margin-left:10px"/>
      <img src="../images/fraunhoferlogo.jpg" alt="Fraunhofer Logo" style="float:right; width:350px; height:auto; margin-top:10px; margin-right:10px"/>
    </div>
    <div class="panel panel-default">
      <div class="col-md-12 panel-body">
      </div>
        <h4>Packing List</h4>
    <div class="col-md-4">
      <h4>Shipped to: </h4>
        <p>Burchett Quality Tool, LTD</p>
        <p>5271 Wynn RD</p>
        <p>Kalamazoo Michigan 49048</p>
        <p>Ph. (269) 344-3041</p>
        <p>Fax (269) 344-6368</p>
    </div>
    <div class="col-md-4 col-md-offset-4">
        <p>Fraunhofer USA</p>
        <p>Center for Coatings and Lazer Applications</p>
        <p>1449 Engineering Reasearch Court</p>
        <p>Michigan State University</p>
        <p>East Lansing, MI, 48824</p>
        <p>Lars Haubold</p>
        <p>Ph. 1-517-432-8179</p>
        <p>Fax. 1-517-432-8167</p>
        <p>Email: lhaubold@fraunhofer.org</p>
    </div>
    <!-- <div class="panel-body"></div> -->
  </div>
  <div>
    <h4 class='col-md-4'>
      <?php
        $sql = "SELECT shipping_date
                FROM POS
                WHERE POID = '$poid';";
        $result = mysqli_query($link, $sql);
        while($row = mysqli_fetch_array($result))
        {
            $shippingDate = $row[0];
        }
        echo "Shipping date: ".$shippingDate;
      ?>
    </h4>
    <h4 class="col-md-3"> Purcash Order # : <?php echo $poid; ?></h4>
    <h4 class="col-md-3"> Initial : LH</h4>
  </div>
  </body>
</html>





























