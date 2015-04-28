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
// if the user security level is not high enough we kill the page and give him a link to the log in page
if($user_sec_lvl < 2){
  echo "<a href='../Login/login.php'>Login Page</a></br>";
  die("You don't have the privlages to view this site.");
}
?>
<html>
<head>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
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
        <div class='col-md-6'>
          <h2>Add a new PO</h2>
          <p class='lead'>Click add a new PO</p>
          <div class='btn-group'>
            <a href='addNewPO.php' class='btn btn-primary btn-lg' >
              Add new PO!
            </a>
            <!-- <a href='../DeletePHP/deletePO.php' class='btn btn-danger btn-lg' >
              Delete existing PO!
            </a><-->
          </div>
        </div>
      </div>
      <div class='row well well-lg'>
        <div class='col-md-6'>
          <h2>Add tools to existing PO</h2>
          <p class='lead'>Here you can add Tools to existing POS</p>
          <div class='input-group col-md-8'>
            <span class="btn-group">
              <a href='addTools2.php' class='btn btn-primary btn-lg' type='submit'>Enter</a>
            </span>
          </div>
        </div>
      </div>
      <div class='row well well-lg'>
        <div class='col-md-6'>
          <h2>Generate a track sheet for your PO</h2>
          <p class='lead'></p>
          <div class='input-group col-md-8'>
            <span class="btn-group">
              <a href='generateTrackSheet.php' class='btn btn-primary btn-lg' type='submit'>Enter</a>
            </span>
          </div>
        </div>
      </div>
      <div class='row well well-lg'>
       <div class='col-md-12'>
        <p><strong>The run might already be in the database so here you can quickly add it to this PO. This dropdown shows all runs from the last 3 days</strong></p>
        <select name="packingsel" id="packingsel" class='dropdown' onchange="setSessionID()">
          <option value="">Choose a PO number</option> 
          <!-- Drop down list of PO numbers with po_ID as the value -->
          <?php
          $sql = "SELECT po_ID, po_number FROM pos ORDER BY receiving_date DESC;";
          $result = mysqli_query($link, $sql);

          if (!$result) {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result)){
            echo '<option id="'.$row['po_ID'].'" value="'.$row['po_ID'].'">'.$row['po_number'].'</option>';
          }
          ?>
        </select>
          <span class="btn-group">
              <a class='btn btn-primary btn-lg' href='../Printouts/packingList.php' target="_blank">Generate packing list</a>
          </span>
        <div id='status_text'></div>
      </div>
      </div>
      </div>
</body>
</html>