<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
$po_ID = $_SESSION["po_ID"];
//$_SESSION["POID"] = $poid;
//find his level of security 
$secsql = "SELECT sec_lvl
           FROM Employees
           WHERE ename = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}

//getting the right po_number
$po_IDsql = "SELECT p.po_number
             FROM   pos p
             WHERE p.po_ID = '$po_ID';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_number = $row[0];
}
$sql = "SELECT l.tool_ID, SUM(lir.number_of_items_in_run), l.quantity, c.coating_type
        FROM lineitem l, lineitem_run lir, coating c, run r
        WHERE l.po_ID = 3
        AND l.lineitem_ID = lir.lineitem_ID
        AND lir.run_ID = r.run_ID
        AND r.coating_ID = c.coating_ID
        GROUP BY lir.lineitem_ID
        ORDER BY lir.lineitem_ID";
$tableresult = mysqli_query($link, $sql);

$customerSql = "SELECT c.customer_name, c.customer_address, c.customer_phone, c.customer_fax
                FROM customer c, pos p
                WHERE p.customer_ID = c.customer_ID
                AND p.po_ID = '$po_ID';";
$customerResult = mysqli_query($link, $customerSql);
while($row = mysqli_fetch_array($customerResult)){
  $customer_name    = $row[0];
  $customer_address = $row[1];
  $customer_phone   = $row[2];
  $customer_fax     = $row[3];
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
<div class='container'>
  <div class='row well well-xs'>
  <div class="col-xs-12">
    <img src="../images/iso.jpg" alt="ISO logo" style="float:right; width:70px; height:auto; margin-top:10px;"/>
    <img src="../images/fraunhoferlogo.jpg" alt="Fraunhofer Logo" style="float:left; width:220px; height:auto; margin-top:10px;"/>
  </div>
  <div style="font-size:9px">
    <div class="col-xs-12">
    <div style="margin-top:20px;margin-bottom:-10px;" class='col-xs-12'><span><h5>Packing list </h5></span></div>
      <div style="margin-top:20px;margin-bottom:-20px;"><hr style="border-width: 1px;border-style:solid"></div>
      <span class='col-xs-12'><strong>Shipped to: </strong></span>
      <span class='col-xs-12'></br></span>
      <span class="col-xs-4"><strong><?php echo $customer_name;?></strong></span>
      <span class="col-xs-4 col-xs-offset-1">Fraunhofer USA</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-3"><?php echo $customer_address;?></span>
      <span class="col-xs-6 col-xs-offset-2">Center for Coatings and Diamond Technologies</span>
    </div>
    <div class="col-xs-12">
    </br>
      <span class="col-xs-3">Ph. <?php echo $customer_phone;?></span>
      <span class="col-xs-5 col-xs-offset-2">1449 Engineering Reasearch Court</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-4">Fax <?php echo $customer_fax;?></span>
      <span class="col-xs-5 col-xs-offset-1">Michigan State University</span>
    </div>
    <div class="col-xs-12">
      <span class="col-xs-4 col-xs-offset-5">East Lansing, MI, 48824</span>
      <span class="col-xs-4 col-xs-offset-5"></br></span>
      <span class="col-xs-4 col-xs-offset-5">Lars Haubold</span>
      <span class="col-xs-5 col-xs-offset-5">Ph. 1-517-432-8179</span>
      <span class="col-xs-4 col-xs-offset-5">Fax. 1-517-432-8167</span>
      <span class="col-xs-5 col-xs-offset-5">Email: lhaubold@fraunhofer.org</span>
    </div>
  </div>
    <div class='col-xs-12' style="margin-top:-19px;margin-bottom:-23px;"><hr style="border-width: 1px;border-style:solid"></div>
    <h5 class='col-xs-4'>
      <?php
      $sql = "SELECT shipping_date
              FROM pos
              WHERE po_ID = '$po_ID';";
      $result = mysqli_query($link, $sql);
      while($row = mysqli_fetch_array($result))
      {
        $shippingDate = $row[0];
      }
      echo "Shipping date: ".$shippingDate;
      ?>
    </h5>
    <span><h5 class="col-xs-4"> Purchase Order # : <?php echo $po_number; ?></h4></span>
    <span><h5 class="col-xs-4"> Initial : LH</h4></span>
    <table class="table">
      <tr>
        <th>Tool type</th>
        <th>Number of tools</th>
        <th>Coating type</th>
      </tr>
      <?php 
      while($row = mysqli_fetch_array($tableresult)){
        echo "<tr>".
              "<td>".$row[0]."</td>".
              "<td>".$row[1]."/".$row[2]."</td>".
              "<td>".$row[3]."</td>";
      }

      ?>
    </table>
    <p>Comments: </p>

</div>
</div>
</body>
</html>





























