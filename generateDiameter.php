<?php

include 'connection.php';

$POID  = mysqli_real_escape_string($link, $_POST['POID']);
$TID = mysqli_real_escape_string($link, $_POST['TID']);


# finding the right diameter and length for the tool with this TID for this company

$sql ="SELECT DISTINCT t.tDiameter
       FROM POS po, Tools t, POTools pot
       WHERE t.TID = '$TID'
       AND po.POID = '$POID'
       AND pot.POID = po.POID
       AND pot.TID = t.TID";

$rightDiaAndLen = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($rightDiaAndLen)){
    $diameter = $row[0];
}
echo " <label for='diameter'>Diameter: </label>
       <input type='number' name='diameter' id='diameter' value='".$diameter."'>";
mysqli_close($link);
?>

