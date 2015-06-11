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
        <h2>Customers</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Fax Number</th>
            <th>Contact Name</th>
            <th class ='col-md-2'>Notes</th>
          </tr>
          <?php
          $sql = "SELECT * FROM customer";
          $result = mysqli_query($link, $sql);
          if (!$result){
           die("Database query failed: " . mysql_error());
         }
         while($row = mysqli_fetch_array($result)){
          echo "<tr>".
          "<td>".$row[0]."</td>".
          "<td>".$row[1]."</td>".
          "<td>".$row[2]."</td>".
          // opens the default email program with that emails in the receievers address
          "<td>"."<a href='mailto:$row[3]'>".$row[3]." "."<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>"."</a>"."</td>".
          // opens the skype call function to that number
          "<td>"."<a href='skype:".$row[4]."?call'"."</a>".$row[4]." <span class='glyphicon glyphicon-earphone' aria-hidden='true'></span>"."</td>".
          "<td>".$row[5]."</td>".
          "<td>".$row[6]."</td>".
          "<td>".$row[7]."</td>".
          "</tr>";

        }
        ?>
      </table>
    </div>
  </div>
<?php
if($user_sec_lvl >=3)
{
  echo"
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h3>Enter customer ID to change the value in some field of the customer. The customer ID can not be changed!</h3>
        <div class='col-md-3'>
          <h4>Enter the Customer ID Number</h4>
          <input type='number' id='input_CID' /></br>
        </div>
        <div class='col-md-3'>
          <p >Change customers address to:</p>
          <input type='text' id='input_address'/>
          <input type='submit' value='Submit' onclick='changeCustomerAddress()' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change customers Email:</p>
          <input type='text' id='input_email'/>
          <input type='submit' value='Submit' onclick='changeCustomerEmail()' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change customers phonenumber to:</p>
          <input type='text' id='input_phonenumber'/>
          <input type='submit' value='Submit' onclick='changeCustomerPhoneNumber()' class='btn btn-primary'/>
        </div>

        <div class='col-md-3'>
          <p >Change customers faxnumber:</p>
          <input type='text' id='input_faxnumber'/>
          <input type='submit' value='Submit' onclick='changeCustomerFax()' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change customers contact name:</p>
          <input type='text' id='input_contact'/>
          <input type='submit' value='Submit' onclick='changeCustomerContact()' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Change customers notes:</p>
          <textarea id='input_notes'></textarea>
          <input type='submit' value='Submit' onclick='changeCustomerNotes()' class='btn btn-primary'/>
        </div>
        <div class='col-md-3'>
          <p >Delete Customer:
            <button type='button'  class='btn btn-default' onclick='deleteCustomer()'>
              <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
            </button>
          </p>";
  }
  ?>
  </div>
  </div>
</body>
</html>