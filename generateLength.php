<?php

include 'connection.php';

$POID  = mysqli_real_escape_string($link, $_POST['POID']);
$TID = mysqli_real_escape_string($link, $_POST['TID']);


# finding the right diameter and length for the tool with this TID for this company

$sql ="SELECT DISTINCT t.tLength
       FROM POS po, Tools t, POTools pot
       WHERE t.TID = '$TID'
       AND po.POID = '$POID'
       AND pot.POID = po.POID
       AND pot.TID = t.TID";

$rightDiaAndLen = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($rightDiaAndLen)){
    $length = $row[0];
}
echo " <label for='length'>Length: </label>
       <input type='number' name='length' id='length' value='".$length."'onfocus='generatePrice()'>";
mysqli_close($link);
?>

