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
    });
  </script>  
</head>
<body>
<?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-6'>
        <h2>Search for POS</h2>
        <div class='input-group col-md-8'>
          <span class="btn-group">
            <a href='filterPOS.php' class='btn btn-primary btn-lg' type='submit'>Enter</a>
          </span>
        </div>
      </div>
    </div>
    <div class='row well well-lg'>
      <div class='col-md-6'>
        <h2>Search for runs</h2>
        <div class='input-group col-md-8'>
          <span class="btn-group">
            <a href='filterRuns.php' class='btn btn-primary btn-lg' type='submit'>Enter</a>
          </span>
        </div>
      </div>
    </div>
  <div class='row well well-lg'>
    <div class='col-md-12'>
      <h2>POS that have not been shipped</h2>
      <table id="report">
        <tr>
          <th class='col-md-1'>PO number</th>
          <th class='col-md-2'>Company Name</th>
          <th class='col-md-2'>Receiving date</th>
          <th class='col-md-2'>Initial inspection</th>
          <th class='col-md-2'>Est run #</th>
        </tr>
        <?php
          /*
              query that shows a list of POS, and some info about them, that have not been shipped yet
              if clicked will display a list of the line items on that PO
          */
          $sql = "SELECT p.po_number, c.customer_name, p.receiving_date, p.initial_inspection, ROUND(SUM(l.est_run_number), 2)
                  FROM pos p, customer c, lineitem l
                  WHERE p.customer_ID = c.customer_ID 
                  AND (p.shipping_date > DATE(NOW()) OR p.shipping_date IS null)
                  AND l.po_ID = p.po_ID
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
            $toolSql = "SELECT l.line_on_po, l.tool_ID, l.quantity, l.price, ROUND(l.price * l.quantity, 2), c.coating_type
                        FROM lineitem l, pos p, coating c
                        WHERE l.po_ID = '$po_ID'
                        AND l.coating_ID = c.coating_ID
                        GROUP BY l.lineitem_ID
                        ORDER BY l.line_on_po;
                        ";
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
             "<div class='col-md-2'> Coating : ".$second[5]."</div>".
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

