<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
$po_ID = $_SESSION["po_ID"];
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
if(!$po_IDresult){
    mysqli_error($link);
}
while($row = mysqli_fetch_array($po_IDresult)){
    $po_number = $row[0];
}
$sql = "SELECT l.tool_ID, SUM(lir.number_of_items_in_run), l.quantity, c.coating_type
        FROM lineitem l, lineitem_run lir, coating c, run r
        WHERE l.po_ID = '$po_ID'
        AND l.lineitem_ID = lir.lineitem_ID
        AND lir.run_ID = r.run_ID
        AND r.coating_ID = c.coating_ID
        GROUP BY lir.lineitem_ID
        ORDER BY lir.lineitem_ID";
$tableresult = mysqli_query($link, $sql);
if(!$tableresult){
    mysqli_error($link);
}
$customerSql = "SELECT c.customer_name, c.customer_address, c.customer_phone, c.customer_fax
                FROM customer c, pos p
                WHERE p.customer_ID = c.customer_ID
                AND p.po_ID = '$po_ID';";
$customerResult = mysqli_query($link, $customerSql);
if(!$customerResult){
    mysqli_error($link);
}
while($row = mysqli_fetch_array($customerResult)){
    $customer_name    = $row[0];
    $customer_address = $row[1];
    $customer_phone   = $row[2];
    $customer_fax     = $row[3];
}

// Split the address to two parts so we can print it in two lines.
$addressArray = explode(',', $customer_address);

$address_line_1 = $addressArray[0];
$address_line_2 = $addressArray[1].$addressArray[2];

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
    <div class="col-xs-12">
      <img src="../images/iso.jpg" alt="ISO logo" style="float:right; width:70px; height:auto; margin-top:10px;"/>
      <img src="../images/fraunhoferlogo.jpg" alt="Fraunhofer Logo" style="float:left; width:220px; height:auto; margin-top:10px;"/>
    </div>
    <div>
      <div class="col-xs-12"> 
        <div class='col-xs-12'>
          <h5>Packing list </h5>
        </div>
        <div>
          <hr>
        </div>
        <div class='col-xs-6'>
          <span class='col-xs-12'><strong>Shipped to: </strong></span>
          <span class='col-xs-12'></br></span>
          <span class="col-xs-12"><strong><?php echo $customer_name;?></strong></span>
          <span class="col-xs-12"><?php echo $address_line_1; ?></span>
          <span class="col-xs-12"><?php echo $address_line_2; ?></span>
          <span class="col-xs-12">Ph. <?php echo $customer_phone;?></span>
          <span class="col-xs-12">Fax <?php echo $customer_fax;?></span>
        </div>
        <div class="col-xs-6">
          <span class="col-xs-12 col-xs-offset-2">Fraunhofer USA</span>
          <span class="col-xs-12 col-xs-offset-2">Center for Coatings and Diamond Technologies</span>
          <span class='col-xs-12'></br></span>
          <span class="col-xs-12 col-xs-offset-2">1449 Engineering Reasearch Court</span>
          <span class="col-xs-12 col-xs-offset-2">Michigan State University</span>
          <span class="col-xs-12 col-xs-offset-2">East Lansing, MI, 48824</span>
          <span class="col-xs-12 col-xs-offset-2"></br></span>
          <span class="col-xs-12 col-xs-offset-2">Lars Haubold</span>
          <span class="col-xs-12 col-xs-offset-2">Ph. 1-517-432-8179</span>
          <span class="col-xs-12 col-xs-offset-2">Fax. 1-517-432-8167</span>
          <span class="col-xs-12 col-xs-offset-2">Email: lhaubold@fraunhofer.org</span>
        </div>
      </div>
      <div class='col-xs-12'>
        <hr>
      </div>
      <div class="col-xs-12" id='aboveTable'>
        <h5 class='col-xs-4'>
          <?php
        // this displayes the date the right way
          $sql = "SELECT DATE_FORMAT(shipping_date,'%m/%d/%y')
                  FROM pos
                  WHERE po_ID = '$po_ID';";
          $result = mysqli_query($link, $sql);
          if(!$result){
              mysqli_error($link);
          }
          while($row = mysqli_fetch_array($result))
          {
              $shippingDate = $row[0];
          }
          echo "Shipping date: ".$shippingDate;
          ?>
        </h5>
        <span><h5 class="col-xs-6"> Purchase Order # :<span id='po_ID'><?php echo $po_number; ?></span></h5></span>
        <span><h5 class="col-xs-2"> Initial : LH</h5></span>
      </div>
      <div class="col-xs-12" id="tableDiv">
        <table class="packingTable col-xs-12">
          <tr class="packingTable"> 
            <th class="packingTable">Tool type</th>
            <th class="packingTable">Number of tools</th>
            <th class="packingTable">Coating type</th>
          </tr>
          <?php 
          while($row = mysqli_fetch_array($tableresult)){
            // If we have coated more tools then we got then
            // we recoated some tools. If there are some broken tools
            // the user puts in a comment but we still ship them all back.
            if($row[1] > $row[2]){
              $row[1] = $row[2];
            }
            echo "<tr class='packingTable'>".
            "<td class='packingTable'>".$row[0]."</td>".
            "<td class='packingTable'>".$row[1]."/".$row[2]."</td>".
            "<td class='packingTable'>".$row[3]."</td>";
          }
          ?>
        </table>
      </div>
      <div class='col-xs-12'>
        <p class='col-xs-3'>Comments: <span class='commentHide'>(if you enter a new comment it replaces the old one)</span></p>
        <textarea id='packing_list_comment' rows='2' cols='41'>
          <?php
              $sql = "SELECT packinglist_comment
                      FROM packinglist
                      WHERE po_ID = '$_SESSION[po_ID]';";
              $result = mysqli_query($link, $sql);
              if(!$result){
                  mysqli_error($link);
              }
              while($row = mysqli_fetch_array($result)){
                  $comment = $row[0];
              }
              echo $comment;
          ?>
        </textarea>
      </div>
      <div class='col-xs-offset-5 commentHide'>
        <button class='btn btn-primary' onclick='storePackingList(<?php echo $_SESSION['po_ID']; ?>)'>Store packing list</button>
      </div>
    </div>
  </div>
</body>
</html>





























