<!DOCTYPE html>
<?php
include 'connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT sec_lvl
           FROM Employees
           WHERE ename = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='js/passScript.js'></script>
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <script type="text/javascript">  
  $(document).ready(function(){
    $("#report tr:odd").addClass("odd");
    $("#report tr:not(.odd)").hide();
    $("#report tr:first-child").show();
    
    $("#report tr.odd").click(function(){
      $(this).next("tr").toggle();
      $(this).find(".arrow").toggleClass("up");
    });
            //$("#report").jExpand();
          });
  </script>  

</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>
      </ul>
      </div>
  </div>
   <!-- _____________________________________________________________--> 
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-6'>
        <h2>View Existing POS</h2>
        <p class='lead'>Here you can search by POS by Number, Customer, maybe some other features later? Runs Machines etc</p>
        <div class='input-group col-md-8'>
          <span class="btn-group">
            <a href='viewExistingPO.php' class='btn btn-primary btn-lg' type='submit'>Enter</a>
          </span>
        </div>
      </div>
    </div>
    <!-- _____________________________________________________________-->
    <div class='row well well-lg'>
      <div class='col-md-6'>
        <h2>Print outs</h2>
        <p class='lead'>Print out Genereal info sheets or track sheets</p>
        <div class='input-group col-md-8'>
          <span class="btn-group">
            <div class='list-group'>
              <a class='list-group-item list-group-item-info' href='printPO.php' target="_blank">Print PO</a>
              <a class='list-group-item list-group-item-info' href='printTrackSheet.php' target="_blank">Print tracksheet</a>
            </div>
          </span>
        </div>
      </div>
    </div>
    <!-- _____________________________________________________________-->

    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Find Existing POS for the company of your choice</h2>
        <p class='lead'>Choose the company to see their active POS Thought of this as a quick look if a customer calls and asks about an old PO. </p>
        <form>
         <select name="POS" onchange="showUser(this.value)">
          <option value="">Select a company:</option> 
          <?php
            $sql = "SELECT CID, cName FROM Customers";
            $result = mysqli_query($link, $sql);
            
            if (!$result) {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result)){
              echo '<option value="'.$row['CID'].'">'.$row['cName'].'</option>';
          }
          ?>
        </select>
      </form>
      <br>
      <div id="txtHint"><b>PO info will be listed here...</b></div>
    </div>
  </div>
  <!--________________________________DivSeparator_____________________________-->
  <div class='row well well-lg'>
    <div class='col-md-12'>
      <h2>All active POS</h2>
      <p class='lead'>These are all our active POS at the moment.(that havent been shipped)</p>
      <table id="report">
        <tr>
          <th class='col-md-1'>POID</th>
          <th class='col-md-2'>Company Name</th>
          <th class='col-md-2'>Receiving date</th>
          <th class='col-md-2'>Initial inspection</th>
          <th class='col-md-2'>Number of Lines</th>
        </tr>
        <?php
          $sql = "SELECT p.POID, c.cName, p.receiving_date, p.initial_inspection, p.nr_of_lines 
                  FROM POS p, Customers c 
                  WHERE p.CID = c.CID 
                  AND (shipping_date > DATE(NOW()) OR shipping_date IS null)
                  GROUP BY p.POID";

          $result = mysqli_query($link, $sql);

          if (!$result) {
            die("Database query failed: " . mysql_error());
          }
          while ($row = mysqli_fetch_array($result)) {
            $rightRow = $row[0];
            echo "<tr>".
            "<td class='col-md-1'>".$row[0]."</td>".
            "<td class='col-md-2'>".$row[1]."</td>".
            "<td class='col-md-2'>".$row[2]."</td>".
            "<td class='col-md-2'>".$row[3]."</td>".
            "<td class='col-md-2'>".$row[4]."</td>".
            "</tr>";
            $toolSql = "SELECT po.line_item, po.TID, po.quantity, t.tPrice, SUM(ROUND(t.tPrice * po.quantity, 2)) 
                        FROM POTools po, Tools t
                        WHERE po.POID = '$rightRow' 
                        AND po.TID = t.TID
                        GROUP BY po.TID
                        ORDER BY po.line_item";

            $toolResult = mysqli_query($link, $toolSql);

            if (!$toolResult) {
              die("Database query failed: " . mysql_error());
            }
            echo "<tr>".
            "<td colspan='7'>";
            while ($second = mysqli_fetch_array($toolResult)){
             echo "<div class='col-md-2'> Item: ".$second[0]."</div>".
             "<div class='col-md-2'> TID : ".$second[1]."</div>".
             "<div class='col-md-2'> Quantity : ".$second[2]."</div>".
             "<div class='col-md-2'> Est Run# : TODO</div>".
             "<div class='col-md-2'> Unit Price : ".$second[3]."</div>".
             "<div class='col-md-2'> Total price : ".$second[4]."</div>";
           }
           echo "</td>"."</tr>";
         }

       ?>
     </div>
   </div>
 </div>

</div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script>
$(function() {
  $('.nav-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
});
</script>

</body>
</html>

<?php
mysql_close($link);
?>

