<?php
/*
	This file sets the session po_ID to the user input
	This is only used for the package list but maybe I should use this feature in more places.
*/
session_start();
include '../connection.php';

$po_ID = mysqli_real_escape_string($link, $_GET['po_ID']);

$_SESSION["po_ID"] = $po_ID;


mysqli_close($link);
?>
