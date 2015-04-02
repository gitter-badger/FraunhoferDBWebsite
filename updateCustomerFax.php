<?php

include 'connection.php';

$CID         = mysqli_real_escape_string($link, $_POST['CID']);
$cFax      = mysqli_real_escape_string($link, $_POST['cFax']);

$sql = "UPDATE Customers 
         SET cFax = '$cFax'
         WHERE CID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>