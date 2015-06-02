<?php
/*
	This file searches for runs with the input from the user
*/
include '../connection.php';
session_start();

$input       = mysqli_real_escape_string($link, $_POST['run_number']);
$first_date  = mysqli_real_escape_string($link, $_POST['first_date']);
$last_date   = mysqli_real_escape_string($link, $_POST['last_date']);
$machine_ID  = mysqli_real_escape_string($link, $_POST['machine_ID']);

// put a wildcard char after the run_number so it displays everything that starts with this string
$stringInput = $input . '%';

// build the basic sql statement
$sql = "SELECT run_ID, run_number, run_date, run_comment
	    FROM run r
	    WHERE 1
	    AND r.run_number LIKE '$stringInput'";

// if the user picked any of the filter options they are added here
if(!empty($first_date)){
	$sql .= "AND run_date >= '$first_date' ";
}
if(!empty($last_date)){
	$sql .= "AND run_date <= '$last_date' ";
}
if(!empty($machine_ID)){
	$sql .= "AND machine_ID = '$machine_ID' ";
}
$sql .= "GROUP BY r.run_ID ";
$sql .= "ORDER BY r.run_date DESC;";
$result = mysqli_query($link, $sql);

if(!$result){echo mysqli_error($link);}

?>
<table id='output' class='table table-striped table-bordered'>
	<tr>
		<th>Run number</th>
		<th>Run date</th>
		<th>Run comment</th>
	<tr>
<?php
/*
*	This while loops generates buttons on each line in the table
*	And a modal page for every run
*	The Modals are displayed when the user clicks the run
*/
while($row = mysqli_fetch_array($result)){
	/*
		This sql is to find the POS linked to the runs found
	*/
	$poSql = "SELECT l.po_ID, p.po_number
			  FROM run r, lineitem l, lineitem_run lir, pos p
			  WHERE r.run_ID LIKE '$row[0]'
			  AND lir.run_ID = r.run_ID
			  AND l.po_ID = p.po_ID
			  AND lir.lineitem_ID = l.lineitem_ID
			  GROUP BY p.po_ID;";
	$poResult = mysqli_query($link, $poSql);


	$toolSql = "SELECT l.tool_ID, lir.number_of_items_in_run, lir.lineitem_run_comment
				FROM run r, lineitem l, lineitem_run lir
				WHERE r.run_ID LIKE '$row[0]'
				AND lir.run_ID = r.run_ID
				AND lir.lineitem_ID = l.lineitem_ID
				GROUP BY lir.lineitem_ID;";
	$toolResult = mysqli_query($link, $toolSql);


	echo "<tr class='output'>".
			"<td><a href='#' data-toggle='modal' data-target='#".$row[0]."'>".$row[1]."</td>".
			"<td>".$row[2]."</td>".
			"<td>".$row[3]."</td>".
		  "</tr>";

	echo "<div class='modal fade' id='".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='".$row[0]."' aria-hidden='true'>
			  <div class='modal-dialog'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			        <h4 class='modal-title' id='myModalLabel'>Run number : ".$row[1]."</h4>
			      </div>
			      <div class='modal-body'>
			        <h3>POS linked to this run</h3>";
					while($poRow = mysqli_fetch_array($poResult)){
						echo "<button onclick='generalInfoRedirect(".$poRow[0].")'>".$poRow[1]."</button>";
					}
				    echo "<h3>Tools linked to this run</h3>";
				    while($toolRow = mysqli_fetch_array($toolResult)){
				   		echo "<p>".$toolRow[0]." : ".$toolRow[1]." : ".$toolRow[2]."</p>";
				    }
				    echo "</div>
			      <div class='modal-footer'>
			        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			      </div>
			    </div>
			  </div>
		   </div>";
}
echo "</table>";
?>
