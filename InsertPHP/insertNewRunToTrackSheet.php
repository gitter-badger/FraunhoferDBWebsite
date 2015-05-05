<?php
/*
	This file adds a relationship between a PO and a run
	If this run is new, i.e. has not been linked to another PO we insert the data in to the run table
	If this run has already been inserted we add it to the pos_run table to make a connection between the run and the PO.
	We do this by calling a procedure in MySQL called check_run found in the procedures.sql file
*/
include '../connection.php';
$POID 				= mysqli_real_escape_string($link, $_POST['POID']);
$runDate  			= mysqli_real_escape_string($link, $_POST['runDate']);
$rCoating 			= mysqli_real_escape_string($link, $_POST['rCoating']);
$machine_run_number = mysqli_real_escape_string($link, $_POST['machine_run_number']);
$ah_pulses		    = mysqli_real_escape_string($link, $_POST['ah_pulses']);
$machine  			= mysqli_real_escape_string($link, $_POST['machine']);
$rcomments			= mysqli_real_escape_string($link, $_POST['rcomments']);
$run_on_this_po		= mysqli_real_escape_string($link, $_POST['run_on_this_PO']);
// This checks what character the user inputed and changes that to the right 
// integer for the database tables.
if($run_on_this_po == 'a' || $run_on_this_po == 'A'){ $run_on_this_po_int = 1;}

if($run_on_this_po == 'b' || $run_on_this_po == 'B'){ $run_on_this_po_int = 2;}

if($run_on_this_po == 'c' || $run_on_this_po == 'C'){ $run_on_this_po_int = 3;}

if($run_on_this_po == 'd' || $run_on_this_po == 'D'){ $run_on_this_po_int = 4;}

if($run_on_this_po == 'e' || $run_on_this_po == 'E'){ $run_on_this_po_int = 5;}

if($run_on_this_po == 'f' || $run_on_this_po == 'F'){ $run_on_this_po_int = 6;}

if($run_on_this_po == 'g' || $run_on_this_po == 'G'){ $run_on_this_po_int = 7;}

// find the right po id from the po number
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$POID';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $POID = $row[0];
}
// this query gets the machine acronym to generate the right run number
$machineSql = "SELECT machine_acronym FROM machine WHERE machine_ID = '$machine'";
$machineResult = mysqli_query($link, $machineSql);

while($row = mysqli_fetch_array($machineResult)){
	$machineAcro = $row[0];
}

$runDate = str_replace("-","",$runDate);
// concatting machine acronym the right chars from the date and the run number for that machine on that date. 
$RID = $machineAcro.$runDate[2].$runDate[3].$runDate[4].$runDate[5].$runDate[6].$runDate[7].$machine_run_number;


// Setting the variables in mysql. Might be an easier way to do this but this works.

$set_run_date = "SET @run_date = '$runDate';";
$set_run_date_result = mysqli_query($link, $set_run_date);

$set_run_number_on_po = "SET @run_number_on_po = '$run_on_this_po_int';";
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

// calling the check_run procedure in MySQL. It can be found in the file procedures.sql
$check_run_procedure = "CALL check_run(@run_date, @run_number_on_po, @run_number_for_machine, @run_number, @machine_ID, @ah_pulses, @run_comment, @coating_ID, @po_ID);";

$result = mysqli_query($link, $check_run_procedure);


if(!$result){
	echo("Input data is fail".mysqli_error($link));
}
 mysqli_close($link);
?>
