<?php
include '../connection.php';
$POID 				= mysqli_real_escape_string($link, $_POST['POID']);
$runDate  			= mysqli_real_escape_string($link, $_POST['runDate']);
$rCoating 			= mysqli_real_escape_string($link, $_POST['rCoating']);
$machine_run_number = mysqli_real_escape_string($link, $_POST['machine_run_number']);
$ah_pulses		    = mysqli_real_escape_string($link, $_POST['ah_pulses']);
$machine  			= mysqli_real_escape_string($link, $_POST['machine']);
$rcomments			= mysqli_real_escape_string($link, $_POST['rcomments']);
$run_on_this_po		= mysqli_real_escape_string($link, $_POST['run_on_this_PO']);
//var_dump($machine_run_number);
$machineSql = "SELECT mAcronym FROM Machine WHERE MID = '$machine'";
$machineResult = mysqli_query($link, $machineSql);

while($row = mysqli_fetch_array($machineResult)){
	$machineAcro = $row[0];
}
//var_dump($machine);

$runDate = str_replace("-","",$runDate);

$RID = $machineAcro.$runDate[2].$runDate[3].$runDate[4].$runDate[5].$runDate[6].$runDate[7].$machine_run_number;

//var_dump($RID);

$sql = "INSERT INTO Runs (RID, POID, runDate, CoatingID, run_number, run_for_machine, ah_pulses, MID, run_comment)
		VALUES('$RID', '$POID' ,'$runDate', '$rCoating', '$run_on_this_po' ,'$machine_run_number', '$ah_pulses', '$machine', '$rcomments')";
$result = mysqli_query($link, $sql);


if($result){
	 echo ("DATA SAVED SUCCESSFULLY");
} else{
	 echo("Input data is fail".mysqli_error($link));
}
 mysqli_close($link);
?>