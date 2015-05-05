<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT security_level
FROM employee
WHERE employee_name = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
if($user_sec_lvl < 2){
  echo "<a href='../Login/login.php'>Login Page</a></br>";
  die("You don't have the privlages to view this site.");
}
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src='../js/bootstrap.min.js'></script>

</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='../selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='../Login/login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>      </ul>
      </div>
    </div>
    <div class='container'>
     <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Choose the right PO number</h2>
        <form>
          <select name='POS' onchange='showTools(this.value)'>
           <option value''>Select a PO#: </option>
            <?php 
            $sql = "SELECT po_ID, po_number FROM pos WHERE shipping_date is NULL";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_array($result))
            {
               echo '<option value="'.$row[0].'">'.$row[1].'</option>';
            }	
            ?>
          </select>
        </form>
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
          <select id="diameter" name="diameter" onchange='generatePrice()' onfocus='generatePrice()'>
            <option value="N/A">N/A</option>
            <option value="1/8">1/8</option>
            <option value="3/16">3/16</option>
            <option value="1/4">1/4</option>
            <option value="3/8">3/8</option>
            <option value="1/2">1/2</option>
            <option value="5/8">5/8</option>
            <option value="3/4">3/4</option>
            <option value="1">1</option>
          </select>
        </div>
        <div class='col-md-4' id='changelength'>
          <label for="length">Length: </label>
          <select id="length" name="length" onchange='generatePrice()' onfocus='generatePrice()'>
            <option value="0">N/A</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class='col-md-4'>
          <label for="quantity">Quantity: </label>
          <input type=" number" name="quantity" id="quantity">
        </div>
        <div class='col-md-4' id='pricediv'>
          <label for="price">Unit Price: </label>
          <input name="price" id='price' value=''></input>
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
    <a class='col-md-offset-9' href='../Printouts/printPO.php' target="_blank">Generate the General information sheet</a>
  </div>
</body>
</html>
