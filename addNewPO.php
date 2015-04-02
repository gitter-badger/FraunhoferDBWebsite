<!DOCTYPE html>
<html>
	<head>
		<title>Fraunhofer CCD</title>
		<link href='css/bootstrap.min.css' rel='stylesheet'>
    	<link href='css/main.css' rel='stylesheet'>
        <script type="text/javascript" src='js/passScript.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
	</head>
	<body>
		<div class='navbar navbar-default navbar-static-top'>
      		<div class='container'>
        		<a href='index.php' class='navbar-brand'>Home Page</a>
		        <ul class='nav navbar-nav navbar-right'>
		          <li><a href='adminView.html'>Admins</a></li>
		          <li><a href='addOrEdit.html'>Add/edit info</a></li>
		        </ul>
          </div>
        </div>
<div class='container'>
      <div class='row well well-lg'>
        <div class='col-md-12'>
      <p>This is the add new po view</p>
<form onsubmit='return false'>
    <p class='col-md-6'>
        <label for="POID" class='col-md-3'>POID:</label>
        <input type="text" name="POID" id="POID">
    </p>
    <p class='col-md-6'>
        <label for="CID" class ='col-md-3'>Company ID:</label>
        <input type="number" name="CID" id="CID">
    </p>
    <p class='col-md-6'>
        <label for="rDate" class='col-md-3'>Receiving Date:</label>
        <input type="rDate" value="<?php echo date('Y-m-d'); ?>" name='rDate' id='rDate'>
    </p>
    <p class='col-md-6'>
        <label for="iInspect" class='col-md-3'>Initial Inspection:</label>
        <input type="text" name="iInspect" id="iInspect">
    </p>
   <p class='col-md-6'>
        <label for="nrOfLines" class='col-md-3'>Number of Lines:</label>
        <input type="number" name='nrOfLines' id='nrOfLines'>
  </p>
  <p class='col-md-6'>
        <label for="employeeId" class='col-md-3'>Employee ID:</label>
        <input type="number" name='employeeId' id='employeeId'>
  </p>
    <input class='col-md-offset-4' type="submit" id="btn_submit" onclick='addPO()' value="Add PO">
</form>
<br/>
<form class='col-md-offset-10' action="addTools2.php">
    <input type="submit" value="Add Tools to PO!">
</form>
      </div>
    </div>
  </div>
	</body>
</html>
