<?php

include '../connection.php';

$CID    = mysqli_real_escape_string($link, $_POST['CID']);
$cEmail = mysqli_real_escape_string($link, $_POST['cEmail']);

$sql = "UPDATE Customers 
        SET cEmail = '$cEmail'
        WHERE CID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>