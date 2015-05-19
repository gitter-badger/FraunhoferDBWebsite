<!DOCTYPE html>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <!-- <link href='../css/main.css' rel='stylesheet'> -->
  <link href='../css/print.css' rel='stylesheet'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/searchScript.js'></script>
</head>
<body>
	<h4>General information sheet</h4>
<?php
/*
        This page generates all the info needed
        for the "general information sheet" after you picked your PO number
        The user picks the ponumber but we are using the ID here  so we can access other tables via foreign keys

*/
session_start();
include '../connection.php';
// the po_ID the user picked from the dropdown list
$q = $_SESSION["po_ID"];
// finds the right info from that po_ID
$sql = "SELECT p.po_number, p.receiving_date, c.customer_name,  p.shipping_date, p.shipping_info, p.initial_inspection 
        FROM pos p, customer c
        WHERE p.customer_ID = c.customer_ID
        AND po_ID = '$q'";
$result = mysqli_query($link, $sql);

// finds all the line items for that PO
$tsql = "SELECT l.line_on_po, l.quantity, l.tool_ID, l.diameter, l.length, IF(l.double_end = 0, 'NO', 'YES') AS 'Double End' ,l.price, SUM(ROUND(l.price * l.quantity, 2)) 
         FROM pos p, lineitem l
         WHERE l.po_ID = '$q'
         AND l.po_ID = p.po_ID
         GROUP BY l.line_on_po";
$tresult = mysqli_query($link, $tsql);

// the sum of all the tools from all the line items on that PO
$sumSql = "SELECT SUM(quantity)
           FROM lineitem
           WHERE po_ID = '$q'";
$sumresult = mysqli_query($link, $sumSql);


while($row = mysqli_fetch_array($result)) {
    $POID = $row[0];
    echo "<div class='col-xs-12'>";
    echo "<span class='col-xs-4'>".'PO number : '.$row[0]."</span>";
    echo "<span class='col-xs-4'>".'Reciving Date : '.$row[1]."</span>";
    echo "<span class='col-xs-4'>".'Customer : '.$row[2]."</span>";
    // echo "<span class='col-xs-6'>". 'Shipping Date : '. $row[3]."</span>";
    echo "<span class='col-xs-4'>". 'Shipping Info : '.$row[4]."</span>";
    echo "<span class='col-xs-4'>". 'Initial inspection : '.$row[5]."</span>";
    echo "</div>";
}

echo "<table>";
echo    "<tr>".
            "<td>Line#</td>".
            "<td>Quantity</td>".  
            "<td>ToolID</td>".
            "<td>diameter</td>".
            "<td>length</td>".
            "<td>double end</td>".
            "<td>unit price</td>".
            "<td>total unit price</td>".
        "</tr>";

while($row = mysqli_fetch_array($tresult)) {
     echo "<tr>".
            "<td>".$row[0]."</td>".
            "<td>".$row[1]."</td>".
            "<td>".$row[2]."</td>".
            "<td>".$row[3]."</td>".
            "<td>".$row[4]."</td>".
            "<td>".$row[5]."</td>".
            "<td>".$row[6]."</td>".
            "<td>".$row[7]."</td>".
          "</tr>";
}
// Finds the price of all the tools on that po
$totalPricesql = "SELECT SUM(ROUND(l.price * l.quantity, 2)) 
                  FROM lineitem l, pos p
                  WHERE p.po_ID = '$q'
                  AND l.po_ID = p.po_ID";

$totalPriceResult = mysqli_query($link, $totalPricesql);

while($row = mysqli_fetch_array($sumresult)){
    echo "<tr>".
    "<td>Total: </td>".
    "<td>".$row[0]."</td>".
    "<td></td>".
    "<td></td>".
    "<td></td>".
    "<td></td>";
}
while($frow = mysqli_fetch_array($totalPriceResult)){
    echo "<td>Total price:</td>".
    "<td>$".$frow[0]."</td>".
    "</tr>";
}


mysqli_close($link);
?>

</body>
</html>