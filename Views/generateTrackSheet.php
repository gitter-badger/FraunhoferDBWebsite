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
<body>
<?php include '../header.php'; ?>
    <div class='container'>
     <div class='row well well-lg'>
      <div class='col-xs-6'>
        <h2>Choose the right PO number</h2>
        <form><select name='POS' onchange='showTools(this.value)'>
          <option value''>Select a PO#: </option>
          <?php 
          /*
           *  dropdown list for po numbers
           *  We pick all the pos that have shipping date not set
           *  but we also want to get all the POS that have had invalid 
           *  dates inserted to them. invalid dates show up as 0000-00-00
           *  this way the user can easily fix the wrong date.
           */
          $sql = "SELECT po_ID, po_number
                  FROM pos
                  WHERE shipping_date IS NULL
                  UNION
                  SELECT po_ID, po_number
                  FROM pos
                  where shipping_date LIKE date_format(0000-00-00, '%Y-%m-%d');";
          $result = mysqli_query($link, $sql);
          while($row = mysqli_fetch_array($result)){
           echo '<option value="'.$row[0].'">'.$row[1].'</option>';
         } 
         echo "</select></form>";
         ?>

         <br><div id="txtHint"><b>PO info will be listed here...</b></div>
       </div>
     </div>
     <div class='row well well-lg'>
       <div class='col-xs-12'>
        <p><strong>The run might already be in the database so here you can quickly add it to this PO. This dropdown shows all runs from the last 3 days</strong></p>
        <select name="runsel" id="runsel" class='dropdown'>
          <option value="">Choose an run number</option> 
          <?php
            $sql = "SELECT run_ID, run_Number FROM run WHERE run_date >= DATE_ADD(CURDATE(), INTERVAL -3 DAY);";
            $result = mysqli_query($link, $sql);

            if (!$result) 
            {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result))
            {
              echo '<option id="'.$row['run_ID'].'" value="'.$row['run_ID'].'">'.$row['run_Number'].'</option>';
            }
          ?>
        </select>
        <button type='button' id='del_button' class='btn btn-primary'onclick="addOldRun()">Add run</button>
      </div>
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
            $sql = "SELECT coating_ID, coating_type FROM coating ORDER BY coating_type ASC";
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
      <label for='delitem' class='col-xs-offset-8'>Insert Run ID to Delete</label>
      <input type="text" placeholder='' id="delitem" name='delitem'/>
      <button type='button' id='del_button' class='btn btn-danger' onclick='delRun(document.getElementById("delitem").value) ; showPORuns()'>
        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      </button>
      <div id="status_text"></div>


      <table id ='txtAddRun'>
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
  <label for='poHelper' class='col-xs-offset-8'>Click button to see the tools on this PO</label>
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
  <label for='addShippingDate' class='col-xs-offset-6'>Add Shipping date and a final inspection to this PO</label>
  <input type="text" id="addShippingDate" name='addShippingDate' value='<?php echo date("Y-m-d") ?>'/>
  <button type='button' id='addShippingDateButton' class='btn btn-primary' onclick='confirmPO()'>
   <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
 </button>
 <a class='col-xs-offset-9' href='../Printouts/trackSheet.php' target="_blank">View tracksheet for this PO</a>
</div>
</div>
<div id='runTools'></div>
</body>
</html>
