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
  <link href='../css/tabs.css' rel='stylesheet'>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src='../js/bootstrap.min.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <!-- This is to fetch the latest po inserted -->
      <?php
      $sql = "SELECT po_number, po_ID 
              FROM pos
              WHERE po_ID = (SELECT MAX(po_ID)
                             FROM pos);";
$result = mysqli_query($link, $sql);

while($row = mysqli_fetch_array($result)){
  $_SESSION["po_number"] = $row[0];
  $_SESSION["po_ID"] = $row[1];
  $po_ID = $row[1];
}
?>
<input type="hidden" id='mostRecentPo_ID' value="<?php echo $po_ID; ?>" />
<div class='col-xs-12'>
  <span>The latest inserted po is : <span><strong><?php echo $_SESSION["po_number"];?></strong></span> <button onclick='showTools(document.getElementById("mostRecentPo_ID").value)'>click</button> if you want to use this one.</span>
</div>
</div>
<div class='row well well-lg'>
  <div class='col-xs-12'>
    <h2>Choose the right PO number</h2>
    <form>
      <select name='POS' onchange='showTools(this.value)'>
       <option value''>Select a PO#: </option>
       <?php 
       $sql = "SELECT po_ID, po_number
               FROM pos
               ORDER BY receiving_date DESC
               LIMIT 12";
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
  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#normal" aria-controls="home" role="tab" data-toggle="tab">Round Tools</a></li>
      <li role="presentation"><a href="#odd" aria-controls="odd" role="tab" data-toggle="tab">Odd shaped tools</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="normal">
       <p>Add new tools and they will appear on the line below.</p>
       <div class='col-xs-4'>
        <label for="lineItem">Item number: </label>
        <input type="number" name="lineItem" id="lineItem">
      </div>
      <div class='col-xs-4'>
        <label for="toolID">Tool ID Number: </label>
        <input type="text" name="toolID" id="tid">
      </div>
      <div class='col-xs-4'id='changediameter'>
        <label for="diameter">Diameter: </label>
        <select id="diameter" name="diameter" onchange='generatePrice()' onfocus='generatePrice()'>
          <option value="0">N/A</option>
          <option value="1/8">1/8</option>
          <option value="3/16">3/16</option>
          <option value="1/4">1/4</option>
          <option value="3/8">3/8</option>
          <option value="1/2">1/2</option>
          <option value="5/8">5/8</option>
          <option value="3/4">3/4</option>
          <option value="1">1</option>
          <option value="1 1/4">1 1/4</option>
          <option value="1 3/8">1 3/8</option>
        </select>
      </div>
      <div class='col-xs-4' id='changelength'>
        <label for="length">Length: </label>
        <select id="length" name="length" onchange='generatePrice()' onfocus='generatePrice()'>
          <option value="0">N/A</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
        </select>
      </div>
      <div class='col-xs-4'>
        <label for="coatingID" class ='col-xs-3'>
          Coating
        </label>
        <select id='coating_sel' onchange='generatePrice()' onfocus='generatePrice()'>
          <option value="">Select coating type:</option> 
          <?php
          $sql = "SELECT coating_ID, coating_type 
                  FROM coating 
                  ORDER BY coating_type ASC";
          $result = mysqli_query($link, $sql);
          if (!$result) 
          {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result))
          {
            echo '<option value="'.$row['coating_ID'].'">'.$row['coating_type'].'</option>';
          }
          ?>
        </select>
      </div>
      <div class='col-xs-4'>
        <label for="quantity">Quantity: </label>
        <input type=" number" name="quantity" id="quantity">
      </div>
      <div class='col-xs-4' id='pricediv'>
        <label for="price">Unit Price: </label>
        <input name="price" id='price' value=''></input>
      </div>
      <div class='col-xs-4'>
        <label for="dblEnd">Double ended? </label>
        <input type="checkbox" name="dlbEnd" id="dblEnd">
      </div>
      <button type='button'  class='btn btn-default col-xs-offset-10' onclick='showPOTools()'>
        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
      </button>
      <button type='button'  class='btn btn-default' onclick='addTool()'>
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      </button>
    </div>
    <!---_______________________________________ -->
    <div role="tabpanel" class="tab-pane" id="odd">
     <p>Add new tools and they will appear on the line below.</p>
     <div class='col-xs-4'>
      <label for="lineItemOdd">Item number: </label>
      <input type="number" name="lineItemOdd" id="lineItemOdd">
    </div>
    <div class='col-xs-4'>
      <label for="toolIDOdd">Tool ID Number: </label>
      <input type="text" name="toolIDOdd" id="tidOdd">
    </div>
    <div class='col-xs-4'>
      <label for="coatingIDOdd" class ='col-xs-3'>
        Coating
      </label>
      <select id='coating_sel_odd' onchange='generatePrice()' onfocus='generatePrice()'>
        <option value="">Select coating type:</option> 
        <?php
        $sql = "SELECT coating_ID, coating_type 
                FROM coating 
                ORDER BY coating_type ASC";
        $result = mysqli_query($link, $sql);
        if (!$result) 
        {
          die("Database query failed: " . mysqli_error($link));
        }
        while($row = mysqli_fetch_array($result))
        {
          echo '<option value="'.$row['coating_ID'].'">'.$row['coating_type'].'</option>';
        }
        ?>
      </select>
    </div>
    <div class='col-xs-4'>
      <label for="quantityOdd">Quantity: </label>
      <input type=" number" name="quantityOdd" id="quantityOdd">
    </div>
    <div class='col-xs-4' id='pricediv'>
      <label for="priceOdd">Unit Price: </label>
      <input name="priceOdd" id='priceOdd' value=''></input>
    </div>
    <div class='col-xs-4'>
      <label for="dblEndOdd">Double ended? </label>
      <input type="checkbox" name="dblEndOdd" id="dblEndOdd">
    </div>
    <button type='button'  class='btn btn-default col-xs-offset-10' onclick='showPOTools()'>
      <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
    </button>
    <button type='button'  class='btn btn-default' onclick='addToolOdd()'>
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
  </div>
</div>
</div>
</div>

<div class='row well well-lg'>
 <div class='col-xs-12'>
  <label for='delitem' class='col-xs-offset-8'>Delete Item</label>
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
  <a class='col-xs-offset-9' href='../Printouts/generalinfo.php' target="_blank">Generate the General information sheet</a>
</div>
</body>
</html>
