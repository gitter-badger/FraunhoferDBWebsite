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
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='../js/passScript.js'></script>
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
<?php include '../header.php'; ?>
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
              <a class='list-group-item list-group-item-info' href='../Printouts/printPO.php' target="_blank">Print PO</a>
              <a class='list-group-item list-group-item-info' href='../Printouts/printTrackSheet.php' target="_blank">Print tracksheet</a>
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
            $sql = "SELECT customer_ID, customer_name FROM customer";
            $result = mysqli_query($link, $sql);
            
            if (!$result) {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result)){
              echo '<option value="'.$row['customer_ID'].'">'.$row['customer_name'].'</option>';
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
          <th class='col-md-1'>PO number</th>
          <th class='col-md-2'>Company Name</th>
          <th class='col-md-2'>Receiving date</th>
          <th class='col-md-2'>Initial inspection</th>
          <th class='col-md-2'>Number of Lines</th>
        </tr>
        <?php
          /*
              query that shows a list of POS, and some info about them, that have not been shipped yet
              if clicked will display a list of the line items on that PO
          */
          $sql = "SELECT p.po_number, c.customer_name, p.receiving_date, p.initial_inspection, p.nr_of_lines 
                  FROM pos p, customer c 
                  WHERE p.customer_ID= c.customer_ID 
                  AND (p.shipping_date > DATE(NOW()) OR p.shipping_date IS null)
                  GROUP BY p.po_ID
                  ORDER BY p.receiving_date";

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

            // first we have to find the right po_ID from the po_Number we get from the user
            $po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$rightRow';";
             $po_IDresult = mysqli_query($link, $po_IDsql);

             while($row = mysqli_fetch_array($po_IDresult)){
                  $po_ID = $row[0];
             }
        /*
            query that shows the information about line items on the clicked po
        */
            $toolSql = "SELECT l.line_on_po, l.tool_ID, l.quantity, l.price, ROUND(l.price * l.quantity, 2) 
                        FROM lineitem l, pos p
                        WHERE l.po_ID = '$po_ID'
                        GROUP BY l.lineitem_ID
                        ORDER BY l.line_on_po;";
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

