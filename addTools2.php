<!DOCTYPE html>
<?php
  include 'connection.php';
?>
<html>
	<head>
		  <title>Fraunhofer CCD</title>
		  <link href='css/bootstrap.min.css' rel='stylesheet'>
    	<link href='css/main.css' rel='stylesheet'>
      <script type="text/javascript" src='js/passScript.js'></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

      <script src='js/bootstrap.min.js'></script>

	</head>
	<body>
		<div class='navbar navbar-default navbar-static-top'>
      		<div class='container'>
        		<a href='index.php' class='navbar-brand'>Home Page</a>
		        <ul class='nav navbar-nav navbar-right'>
		          <li><a href='adminView.php'>Admins</a></li>
		          <li><a href='addOrEdit.html'>Add/edit info</a></li>
		        </ul>
      		</div>
  		</div>

<div class='container'>
       <div class='row well well-lg'>
        <div class='col-md-12'>
          <h2>Choose the right PO number</h2>
            <form><select name='POS' onchange='showTools(this.value)'>
              <option value''>Select a PO#: </option>
          <?php 
                $sql = "SELECT POID FROM POS WHERE shipping_date is NULL";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_array($result)){
	 		           echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	            }	
                echo "</select></form>";
          ?>

        <br><div id="txtHint"><b>PO info will be listed here...</b></div>
      </div>
    </div>
  <div class='row well well-lg'>
   <div class='col-md-12'>
      <p>Add new tools and they will appear on the line below.</p>
      <div class='col-md-4'>
        <label for="lineItem">Item number: </label>
        <input type="number" name="lineItem" id="lineItem">
      </div>
      <div class='col-md-4'>
        <label for="toolID">Tool ID Number: </label>
        <input type="text" name="toolID" id="tid">
      </div>
      <div class='col-md-4'id='changediameter'>
        <label for="diameter">Diameter: </label>
        <input type="text" name="diameter" id="diameter">
      </div>
      <div class='col-md-4' id='changelength'>
        <label for="length">Length: </label>
        <input type="number" name="length" id="length" onchange='generatePrice()' onfocus='generatePrice()'>
      </div>
      <div class='col-md-4'>
        <label for="quantity">Quantity: </label>
        <input type=" number" name="quantity" id="quantity">
      </div>
      <div class='col-md-4' id='status_text'>
        <label for="price">Unit Price: </label>
        <input type=" number" name="price" id='price'>
      </div>
      <div class='col-md-4'>
        <label for="dblEnd">Double ended? </label>
        <input type="checkbox" name="dlbEnd" id="dblEnd">
      </div>
        <button type='button'  class='btn btn-default col-md-offset-10' onclick='showPOTools()'>
          <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
        </button>
        <button type='button'  class='btn btn-default' onclick='addTool()'>
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>
</div>

  <div class='row well well-lg'>
   <div class='col-md-12'>
        <label for='delitem' class='col-md-offset-8'>Delete Item</label>
        <input type="text" id="del_number" name='delitem'/>
        <button type='button' id='delitem' class='btn btn-danger' onclick='delTool(document.getElementById("del_number").value) ; showPOTools()'>
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
</div>
</div>

        <div id="status_text"></div>



  <table id ='txtAdd'>
  </table>
    <div class='navbar navbar-default navbar-static-bottom'>
        <a class='col-md-offset-9' href='printPO.php' target="_blank">Generate the General information sheet</a>
    </div>
  </body>
</html>
