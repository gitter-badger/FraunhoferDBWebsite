<?php

include '../connection.php';

$CID    = mysqli_real_escape_string($link, $_POST['CID']);
$cNotes = mysqli_real_escape_string($link, $_POST['cNotes']);

$sql = "UPDATE customer 
        SET customer_notes = '$cNotes'
        WHERE customer_ID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>