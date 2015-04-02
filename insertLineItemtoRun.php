<?php
include 'connection.php';
# clean the data recieved from the html
$POID 			 = mysqli_real_escape_string($link, $_POST['POID']);
$lineItem  		 = mysqli_real_escape_string($link, $_POST['lineItem']);
$number_of_tools = mysqli_real_escape_string($link, $_POST['number_of_tools']);
$runNumber 		 = mysqli_real_escape_string($link, $_POST['runNumber']);
$final_comment 	 = mysqli_real_escape_string($link, $_POST['final_comment']);



#finding the right runID from our database
$findRightRun = "SELECT DISTINCT RID
				 FROM Runs r
				 WHERE r.POID ='$POID'
				 AND r.run_number = '$runNumber'";
# running the query
$resultRun = mysqli_query($link, $findRightRun);
# binding the result to a variable $RID
while($row = mysqli_fetch_array($resultRun)){
	$RID = $row[0];
}


#MySql insert with the data recieved from HTML
$sql = "INSERT INTO RunPOS(POID, RID, line_item, number_of_items, final_comment) VALUES ('$POID','$RID', '$lineItem', '$number_of_tools', '$final_comment')";

# running the insert query
$result = mysqli_query($link, $sql);

#if successfull let user know
if($result){
	 echo ("DATA SAVED SUCCESSFULLY");
} 
#if fail let user know what went wrong
if (!$result) {
    $message  = 'Invalid result query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole result query: ' . $query;
    die($message);
}
mysqli_close($link);
?>
