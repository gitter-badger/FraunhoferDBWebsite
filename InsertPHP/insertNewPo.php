<?php
include '../connection.php';
 
// Escape user inputs for security
$POID 		 = mysqli_real_escape_string($link, $_POST['POID']);
$CID 		 = mysqli_real_escape_string($link, $_POST['CID']);
$rDate 		 = mysqli_real_escape_string($link, $_POST['rDate']);
$iInspect	 = mysqli_real_escape_string($link, $_POST['iInspect']);
$nrOfLines   = mysqli_real_escape_string($link, $_POST['nrOfLines']);
$employeeId  = mysqli_real_escape_string($link, $_POST['employeeId']);
if($POID == ""){
	echo "You need to give the PO an ID";
}
 else{
// attempt insert query execution
$sql = "INSERT INTO POS VALUES ('$POID', '$CID', '$rDate', '$iInspect', 0, '$nrOfLines', null, null)";
$result = mysqli_query($link, $sql);
if($result){
    echo ("PO was stored");
} else{
    echo("PO storing didnt go right". mysqli_error($link));
}
$employeeSql = "INSERT INTO WorkedOn VALUES ('$POID', '$employeeId')";
$employeeResult = mysqli_query($link, $employeeSql);
if($employeeResult){
    echo ("Saved in worked on");
} else{
    echo("Worked on failed");
}

}
// close connection
mysqli_close($link);
?>

   