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
        <form><select name='POS' onchange='showTools(this.value)'>
          <option value''>Select a PO#: </option>
          <?php 
          $sql = "SELECT po_ID FROM pos WHERE shipping_date IS NULL";
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
        <p class='col-md-12'>Add info about a run. You can add as many runs as you want. Below we will then add tools to each run.</p>
      </div>
      <div class='col-md-12'>
        <p class='col-md-4'>
        <label for="coatingID" class ='col-md-3'>Coating</label>
        <select id='coatingID'>
          <option value="">Select coating type:</option> 
          <?php
          $sql = "SELECT coating_ID, coating_type FROM coating";
          $result = mysqli_query($link, $sql);
          if (!$result) {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result)){
            echo '<option value="'.$row['coating_ID'].'">'.$row['coating_type'].'</option>';
          }
          ?>
        </select>
      </p>
        <p class='col-md-4'>
          <label for="run_number">run_number# on this PO: </label>
          <input type=" number" name="run_number" id="run_number">
        </p>
        <p class='col-md-4'>
          <label for="machine_run_number">run# for the machine </label>
          <input type=" number" name="machine_run_number" id="machine_run_number">
        </p>
        <p class='col-md-4'>
          <label for="ah_pulses">AH/Pulses </label>
          <input type="text" name="ah_pulses" id="ah_pulses">
        </p>
        <p class='col-md-4'>
        <label for="machineID" class ='col-md-3'>Machine</label>
        <select id='machineID'>
          <option value="">Select a machine:</option> 
          <?php
          $sql = "SELECT machine_ID, machine_acronym FROM machine";
          $result = mysqli_query($link, $sql);
          if (!$result) {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result)){
            echo '<option value="'.$row['MID'].'">'.$row['mAcronym'].'</option>';
          }
          ?>
        </select>
        </p>
        <p class='col-md-4'>
          <label for="runDate">Date: </label>
          <input type=" number" name="runDate" id="runDate" value='<?php echo date('Y-m-d'); ?>'>
        </p>
        <p class='col-md-4'>
          <label for="rcomments">Comments </label>
          <input type="text" name="rcomments" id="rcomments">
        </p>
        <div id="status_text"></div>
        <button type='button'  class='btn btn-default col-md-offset-10' onclick='showPORuns()'>
          <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
        </button>
        <button type='button'  class='btn btn-default' onclick='addRun()'>
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <label for='delitem' class='col-md-offset-8'>Insert Run ID to Delete</label>
        <input type="text" id="delitem" name='delitem'/>
        <button type='button' id='del_button' class='btn btn-danger' onclick='delRun(document.getElementById("delitem").value) ; showPORuns()'>
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
        <div id="status_text"></div>


        <table id ='txtAddRun'>
        </table>
      </div>
    </div>

    <div class='row well well-lg'>
     <div class='col-md-12'>
      <p>Asign runs to tools by using the right line item from the general information sheet.</p>
      <p class='col-md-4'>
        <label for="lineItem">Line Item: </label>
        <input type='number' id='lineItem' name='lineItem'>
      </p>
      <p class='col-md-4'>
        <label for="number_of_tools">Number of Tools: </label>
        <input type=" number" name="number_of_tools" id="number_of_tools">
      </p>
      <p class='col-md-4'>
        <label for="runNumber">RunNumber: </label>
        <input type="text" name="runNumber" id="runNumber">
      </p>
      <p class='col-md-4'>
        <label for="final_comment">Final Comment: </label>
        <input type="text" name="final_comment" id="final_comment">
      </p>
      <button type='button'  class='btn btn-default col-md-offset-10' onclick='showRunTools()'>
        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
      </button>
      <button type='button'  class='btn btn-default' onclick='addLineItemToRun()'>
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      </button>
      <label for='delRunTool' class='col-md-offset-7'>Insert line item and to delete</label>
      <input type="text" id="delRunTool" name='delRunTool'/>
      <button type='button' id='delRunToolButton' class='btn btn-danger' onclick='delRunTool(document.getElementById("delRunTool").value) ; showRunTools()'>
        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      </button>
      <table id ='txtAddToolToRun'>
      </table>

    </div>
  </div>
  <div class='navbar navbar-default navbar-static-bottom'>
    <label for='fInspect' class='col-md-offset-7'>Add text for final inspection</label>
    <input type="text" id="fInspect" name='fInspect'/>
    <label for='addShippingDate' class='col-md-offset-6'>Add Shipping date and a final inspection to this PO</label>
    <input type="text" id="addShippingDate" name='addShippingDate' value='<?php echo date("Y-m-d") ?>'/>
    <button type='button' id='addShippingDateButton' class='btn btn-primary' onclick='addShipDateToPO(document.getElementById("addShippingDate").value)'>
     <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
   </button>
   <a class='col-md-offset-9' href='../Printouts/printTrackSheet.php' target="_blank">Get a Printable version of the tracksheet</a>
 </div>
</body>
</html>
