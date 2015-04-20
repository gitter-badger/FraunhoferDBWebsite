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
// find the right po id from the po number
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$POID';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $POID = $row[0];
}
// this query gets the machine acronym to generate the right run number
//the run number is a combination of the machine acronym, the date and what run of the day on this machine it is.
$machineSql = "SELECT machine_acronym FROM machine WHERE machine_ID = '$machine'";
$machineResult = mysqli_query($link, $machineSql);

while($row = mysqli_fetch_array($machineResult)){
	$machineAcro = $row[0];
}

$runDate = str_replace("-","",$runDate);
// concatting machine acronym the right chars from the date and the run number for that machine on that date. 
$RID = $machineAcro.$runDate[2].$runDate[3].$runDate[4].$runDate[5].$runDate[6].$runDate[7].$machine_run_number;

var_dump($RID);

// making data to call the check_run_procedure

$set_run_date = "SET @run_date = '$runDate';";
$set_run_date_result = mysqli_query($link, $set_run_date);

$set_run_number_on_po = "SET @run_number_on_po = '$run_on_this_po';";
$set_run_number_on_po_result = mysqli_query($link, $set_run_number_on_po);

$set_run_number_for_machine = "SET @run_number_for_machine = '$machine_run_number';";
$set_run_number_for_machine_result = mysqli_query($link, $set_run_number_for_machine);

$set_run_number = "SET @run_number = '$RID';";
$set_run_number_result = mysqli_query($link, $set_run_number);

$set_ah_pulses = "SET @ah_pulses = '$ah_pulses';";
$set_ah_pulses_result = mysqli_query($link, $set_ah_pulses);

$set_run_comments = "SET @run_comment = '$rcomments';";
$set_run_comments_result = mysqli_query($link, $set_run_comments);

$set_po_ID = "SET @po_ID = '$POID';";
$set_po_ID_result = mysqli_query($link, $set_po_ID);

$set_coating_ID = "SET @coating_ID = '$rCoating';";
$set_coating_ID_result = mysqli_query($link, $set_coating_ID);

$set_machine_ID = "SET @machine_ID = '$machine';";
$set_machine_ID_result = mysqli_query($link, $set_machine_ID);


$check_run_procedure = "CALL check_run(@run_date, @run_number_on_po, @run_number_for_machine, @run_number, @machine_ID, @ah_pulses, @run_comment, @coating_ID, @po_ID);";

$result = mysqli_query($link, $check_run_procedure);


if(!$result){
	echo("Input data is fail".mysqli_error($link));
}
 mysqli_close($link);
?>
