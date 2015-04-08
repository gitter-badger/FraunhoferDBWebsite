<?php

include '../connection.php';
//POID from the dropdown list
$q = mysqli_real_escape_string($link, $_GET['q']);

//sql for table data
$sql = "SELECT po.line_item, po.quantity, po.TID, t.tDiameter, t.tLength, t.double_end, t.tPrice, ROUND(t.tPrice * po.quantity, 2) 
        FROM POTools po, Tools t, POS p   
        WHERE po.POID = '$q'
        AND po.POID = p.POID
        AND p.CID = t.CID
        AND po.TID = t.TID
        ORDER BY po.line_item";
$result = mysqli_query($link, $sql);


//sql for bottom row
$sumSql = "SELECT COUNT('*'), SUM(quantity)
           FROM POTools po
           WHERE po.POID = '$q'";
$sumresult = mysqli_query($link, $sumSql);
//if sum table is wrong
if (!$sumresult) {
    $message  = 'Invalid sum query: ' . mysql_error() . "\n";
    $message .= 'Whole sum query: ' . $query;
    die($message);
}
//if table query is wrong
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
//building the header of the table.
   echo         "<tr>".
                "<td>Line#</td>".
                "<td>Quantity</td>".                
                "<td>ToolID</td>".
                "<td>Diameter</td>".
                "<td>Length</td>".
                "<td>DblEnd</td>".      
                "<td>Price</td>".
                "<td>total unit price</td>".
                "</tr>";
//filling it with data from POTools
while($row = mysqli_fetch_array($result)) {
   echo 
        "<tr>".
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
$totalSumSql = "SELECT SUM(ROUND(t.tPrice * po.quantity, 2)) 
                FROM POTools po, Tools t   
                WHERE po.POID = '$q'
                AND po.TID = t.TID";
$totalSumResult = mysqli_query($link, $totalSumSql);


while($row = mysqli_fetch_array($sumresult)){
    echo "<tr>".
         "<td>".'Number of Items: '.$row[0]."</td>".
         "<td>".'Number of tools: '.$row[1]."</td>".
         "<td></td>".
         "<td></td>".
         "<td></td>".
         "<td></td>".
         "<td>Total $: </td>";
}
while($row = mysqli_fetch_array($totalSumResult)){

    echo "<td>".$row[0]."</td>".
         "</tr></table>";
}
 mysqli_close($link);
?>





















