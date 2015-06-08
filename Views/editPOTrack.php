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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src='../js/bootstrap.min.js'></script>
</head>
<body>
  <?php
  // getting the right po_number from the Session po_ID
  $po_ID = $_SESSION["po_ID"];
  $sql = "SELECT po_number
          FROM pos
          WHERE po_ID = '$po_ID'";
  $result = mysqli_query($link, $sql);
  while($row = mysqli_fetch_array($result)){
    $po_number = $row[0];
  }
  ?>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <span>You are editing PO number </span><span id='POID'><?php echo $po_number;?></span>
    </div>
    <div class='row well well-lg'>
     <div class='col-xs-12'>
      <p class='col-xs-12'><strong>Add info about a run. You can add runs from a - g. The runID is auto generated</strong></p>
    </div>
    <div class='col-xs-12'>
      <p class='col-xs-4'>
        <label for="coatingID" class ='col-xs-3'>Coating</label>
        <select id='coatingID'>
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
      </p>
      <p class='col-xs-4'>
        <label for="run_number">Run# on this PO: (a,b,c...)</label>
        <input type="text" name="run_number" id="run_number">
      </p>
      <p class='col-xs-4'>
        <label for="machine_run_number">Run# for machine(1,2,3)</label>
        <input type=" number" name="machine_run_number" id="machine_run_number">
      </p>
      <p class='col-xs-4'>
        <label for="ah_pulses">AH/Pulses </label>
        <input type="text" name="ah_pulses" id="ah_pulses">
      </p>
      <p class='col-xs-4'>
        <label for="machineID" class ='col-xs-3'>Machine</label>
        <select id='machineID'>
          <option value="">Select a machine:</option> 
          <?php
          $sql = "SELECT machine_ID, machine_acronym FROM machine";
          $result = mysqli_query($link, $sql);
          if (!$result) {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result)){
            echo '<option value="'.$row['machine_ID'].'">'.$row['machine_acronym'].'</option>';
          }
          ?>
        </select>
      </p>
      <p class='col-xs-4'>
        <label for="runDate">Date: (yyyy-mm-dd)</label>
        <input type=" number" name="runDate" id="runDate" value='<?php echo date('Y-m-d'); ?>'>
      </p>
      <p class='col-xs-4'>
        <label for="rcomments">Comments </label>
        <input type="text" name="rcomments" id="rcomments">
      </p>
      <div id="status_text"></div>
      <button type='button'  class='btn btn-default col-xs-offset-10' onclick='showPORuns()'>
        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
      </button>
      <button type='button'  class='btn btn-default' onclick='addRun()'>
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      </button>
      <label for='delitem' class='col-xs-offset-7'>Insert Run ID to Delete</label>
      <input type="text" placeholder='' id="delitem" name='delitem'/>
      <button type='button' id='del_button' class='btn btn-danger' onclick='delRun(document.getElementById("delitem").value) ; showPORuns()'>
        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      </button>
      <div id="status_text"></div>
      <table id='txtAddRun'>
      </table>
    </div>
  </div>

  <div class='row well well-lg'>
   <div class='col-xs-12'>
    <p>Asign runs to tools by using the right line item from the general information sheet.</p>
    <p class='col-xs-4'>
      <label for="lineItem">Line Item: </label>
      <input type='number' id='lineItem' name='lineItem'>
    </p>
    <p class='col-xs-4'>
      <label for="number_of_tools">Number of Tools: </label>
      <input type=" number" name="number_of_tools" id="number_of_tools">
    </p>
    <p class='col-xs-4'>
      <label for="runNumber">RunNumber(a,b,c...): </label>
      <input type="text" name="runNumber" id="runNumber">
    </p>
    <p class='col-xs-4'>
      <label for="final_comment">Final Comment: </label>
      <input type="text" name="final_comment" id="final_comment">
    </p>
    <button type='button'  class='btn btn-default col-xs-offset-10' onclick='showRunTools()'>
      <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
    </button>
    <button type='button'  class='btn btn-default' onclick='addLineItemToRun()'>
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>

    <table id ='txtAddToolToRun'>
    </table>
    <div id="status_text2"></div>
  </div>
  <label for='delRunTool' class='col-xs-offset-6'>Insert line# and run#</label>
  <input type="text" id="delRunTool" placeholder='Line Item#' name='delRunTool'/>
  <input type="text" placeholder='Run number' id="delRunToolRun" name='delRunToolRun'/>
  <button type='button' id='delRunToolButton' class='btn btn-danger' onclick='delRunTool(document.getElementById("delRunTool").value, document.getElementById("delRunToolRun").value) ; showRunTools()'>
    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
  </button>
</div>

<div class='row well well-lg'>
  <label for='poHelper' class='col-xs-offset-7'>Click button to see the tools on this PO</label>
  <button type='button' id='poHelperBtn' class='btn btn-primary' onclick='displayHelper()'>
    <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
  </button>
  <div id="displayHelper">
    <ul class="list-group">
      <!-- quick view of line items comes here from php -->
    </ul>
  </div>
</div> 
<div class='row well well-lg'>
  <div class="col-xs-12">
    <label for='fInspect' class='col-xs-offset-7'>Add text for final inspection</label>
    <input type="text" id="fInspect" name='fInspect'/>
    <label for='addShippingDate' class='col-xs-offset-5'>Add Shipping date and a final inspection to this PO</label>
    <input type="text" id="addShippingDate" name='addShippingDate' value='<?php echo date("Y-m-d") ?>'/>
    <button type='button' id='addShippingDateButton' class='btn btn-primary' onclick='confirmPO()'>
     <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
   </button>
   <a class='col-xs-offset-9' href='../Printouts/trackSheet.php' target="_blank">View tracksheet for this PO</a>
   <a class='col-xs-offset-9' href='../Printouts/packingList.php' target="_blank">View packinglist for this PO</a>
 </div>
</div>
<div id='runTools'></div>
</body>
</html>
