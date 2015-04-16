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
  <link href='../css/print.css' rel='stylesheet'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
<body>
  <div class="col-xs-12">
    <img src="../images/iso.jpg" alt="ISO logo" style="float:left; width:70px; height:auto; margin-top:10px; margin-left:10px"/>
    <span class='col-xs-offset-4'><strong>Packing list: </strong></span>
    <img src="../images/fraunhoferlogo.jpg" alt="Fraunhofer Logo" style="float:right; width:150px; height:auto; margin-top:10px; margin-right:10px"/>
  </div>
    <div class="col-xs-12">
      <span class='col-xs-12'><strong>Shipped to: </strong></span>
      <span class='col-xs-12'></br></span>
      <span class="col-xs-4">Burchett Quality Tool, LTD</span>
      <span class="col-xs-4 col-xs-offset-1">Fraunhofer USA</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-3">5271 Wynn Rd. Kalamazoo MI 49048</span>
      <span class="col-xs-6 col-xs-offset-2">Center for Coatings and Lazer Applications</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-3">Ph. (269) 344-3041</span>
      <span class="col-xs-5 col-xs-offset-2">1449 Engineering Reasearch Court</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-3">Fax (269) 344-6368</span>
      <span class="col-xs-5 col-xs-offset-2">Michigan State University</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-4 col-xs-offset-5">East Lansing, MI, 48824</span>
      <span class="col-xs-4 col-xs-offset-5"></br></span>
      <span class="col-xs-4 col-xs-offset-5">Lars Haubold</span>
      <span class="col-xs-5 col-xs-offset-5">Ph. 1-517-432-8179</span>
      <span class="col-xs-4 col-xs-offset-5">Fax. 1-517-432-8167</span>
      <span class="col-xs-5 col-xs-offset-5">Email: lhaubold@fraunhofer.org</span>
    </div>
    <!-- <div class="panel-body"></div> -->
  </div>
  <div class='col-xs-12'>
    <h5 class='col-xs-4'>
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
    </h5>
    <span><h5 class="col-xs-4"> Purcash Order # : <?php echo $poid; ?></h4></span>
    <span><h5 class="col-xs-4"> Initial : LH</h4></span>
  </div>
  <div class="col-md-12">
    <table class="table">
      <tr>
        <th>Tool type</th>
        <th>Number of tools</th>
        <th>Coating type</th>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
      <tr>
        <td>Testitem</td>
        <td>Test number</td>
        <td>Coating type</td>
      </tr>
    </table>
  </div>
  <div>
    <p>Comments: </p>
  </div>
</body>
</html>





























