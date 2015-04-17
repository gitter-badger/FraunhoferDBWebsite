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
#add comment for github test
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>

  <script type="text/javascript" src='../js/passScript.js'></script>
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
        <h2>Here is a list of all our Customers</h2>
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
          "<td>"."<a href='mailto:$row[3]'>".$row[3]." "."<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>"."</a>"."</td>".
          "<td>"."<a href='skype:".$row[4]."?call'"."</a>".$row[4]." <span class='glyphicon glyphicon-earphone' aria-hidden='true'></span>"."</td>".
          "<td>".$row[5]."</td>".
          "<td>".$row[8]."</td>".
          "<td>".$row[9]."</td>".
          "</tr>";

        }
    //<a href="skype:echo123?call">Call the Skype Echo / Sound Test Service</a>
        mysqli_close($link);

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
        <h2>Edit Customer ID to change the value in some field of the Customer. The customer ID can not be changed!</h2>
        <div class='col-md-3'>
          <h3 >Enter the Customer ID Number</h3>
          <input type='text' id='input_CID' /></br>
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
          </p>
        </div>
      </div>
    </div>";
  }
  ?>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
</body>
</html>