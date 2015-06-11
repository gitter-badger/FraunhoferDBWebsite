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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <!-- Getting the po_number from the po_ID -->
        <?php 
        $po_ID = $_SESSION["po_ID"];
        $sql = "SELECT po_number, receiving_date, initial_inspection, nr_of_lines, shipping_info
                FROM pos
                WHERE po_ID = '$po_ID'";
        $result = mysqli_query($link, $sql);
        while($row = mysqli_fetch_array($result)){
          $po_number = $row[0];
          $receiving_date = $row[1];
          $initial_inspection = $row[2];
          $nr_of_lines = $row[3];
          $shipping_info = $row[4];
        }
        ?>
        <h1><?php echo $po_number; ?></h1>
        <div class='col-md-12'>
            <p>
              <strong>Receiving date : </strong><?php echo $receiving_date; ?>
            </p>
            <input type='date' id='input_date'/>
            <input type='submit' value='Change' onclick='changePOReceivingDate(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-12'>
            <p>
              <strong>Initial inspection : </strong><?php echo $initial_inspection; ?>
            </p>
            <input type='text' id='input_inital_inspect'/>
            <input type='submit' value='Change' onclick='changePOInitialInspection(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-12'>
            <p>
              <strong>Number of lines on PO : </strong><?php echo $nr_of_lines; ?>
            </p>
            <input type='number' id='input_number_of_lines'/>
            <input type='submit' value='Change' onclick='changePONumberOfLines(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-12'>
          <p>
            <strong>Shipping info: </strong><?php echo $shipping_info; ?>
          </p>
          <select id='shipping_sel'>
            <option value='Ground'>Ground</option>
            <option value='3 day'>3 day</option>
            <option value='2 day'>2 day</option>
            <option value='next day'>Next day</option>
            <option value='fedex'>Fedex</option>
            <option value='other'>Other</option>
          </select>
          <input type='submit' value='Change' onclick='changePOShippingInfo(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>        
        <h4>Lineitems</h4>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Line on PO</th>
            <th>Quantity</th>
            <th>price</th>
            <th>Tool ID</th>
            <th>Diameter</th>
            <th>Length</th>
            <th>Double end</th>
          </tr>
          <?php
          $sql = "SELECT line_on_po, quantity, price, tool_ID, diameter, length, IF(double_end = 0, 'NO', 'YES')
                  FROM lineitem l, pos p
                  WHERE l.po_ID = '$po_ID'
                  AND l.po_ID = p.po_ID";
          $result = mysqli_query($link, $sql);
          if (!$result){
            die("Database query failed: " . mysql_error());
          }
          while($row = mysqli_fetch_array($result)){
            echo "<tr>".
            "<td>".$row[0]."</td>".
            "<td>".$row[1]."</td>".
            "<td>".$row[2]."</td>".
            "<td>".$row[3]."</td>".
            "<td>".$row[4]."</td>".
            "<td>".$row[5]."</td>".
            "<td>".$row[6]."</td>".
            "</tr>";
          }
          ?>
        </table>
      </div>
    </div>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Enter the line number to edit.</h2>
        <div class='col-md-3'>
          <h4>Enter the line on the PO you want to change</h4>
          <input type='number' id='line' /></br>
        </div>
        <div class='col-md-3'>
          <p>Change the quantity</p>
          <input type='number' id='input_quantity'/>
          <input type='submit' value='Change' onclick='changeLineitemQuantity(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p>Change the price</p>
          <input type='text' id='input_price'/>
          <input type='submit' value='Change' onclick='changeLineitemPrice(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change the tool ID</p>
          <input type='text' id='input_tool'/>
          <input type='submit' value='Change' onclick='changeLineitemTool(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p>Change the diameter</p>
          <input type='text' id='input_diameter'/>
          <input type='submit' value='Change' onclick='changeLineitemDiameter(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change the length</p>
          <input type='text' id='input_length'/>
          <input type='submit' value='Change' onclick='changeLineitemLength(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change double end (Enter 1 to change to double end. Enter 0 to change to single end)</p>
          <input type='text' id='input_end'/>
          <input type='submit' value='Change' onclick='changeLineitemDoubleEnd(<?php echo $po_ID;?>)' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p>Delete lineitem</p>
          <input type='submit' value='Change' onclick='deleteLineitem(<?php echo $po_ID;?>)' class='btn btn-danger'/>
        </div>
      </div>
    </div>
  </div>
</body>
</html>