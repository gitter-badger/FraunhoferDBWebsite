<?php
include '../connection.php';
 
// Escape user inputs for security
$mName = mysqli_real_escape_string($link, $_POST['mname']);
$mAcro = mysqli_real_escape_string($link, $_POST['macro']);

// attempt insert query execution
$sql = "INSERT INTO Machine(mName, mAcronym) VALUES ('$mName', '$mAcro')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>
