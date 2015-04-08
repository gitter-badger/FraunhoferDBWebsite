<?php

include '../connection.php';

$CID = mysqli_real_escape_string($link, $_POST['CID']);

$sql =  "DELETE FROM Customers 
         WHERE CID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>
