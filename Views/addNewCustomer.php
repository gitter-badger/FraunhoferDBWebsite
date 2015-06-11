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
    <script src='../js/bootstrap.min.js'></script>


</head>
<body>
    <?php include '../header.php'; ?>
    <div class='container'>
        <div class='row well well-lg'>
            <div class='col-md-12'>
                <h5>Add new customer</h5>
                <form id='customerForm' onsubmit="return false">
                    <p class='col-md-6'>
                        <label for="cName" class='col-md-3' required>Company Name: </label>
                        <input type="text" name="cName" id="cName">
                    </p>
                    <p class='col-md-6'>
                        <label for="cAddress" class ='col-md-3'>Company Address: </label>
                        <input type="text" name="cAddress" id="cAddress">
                    </p>
                    <p class='col-md-6'>
                        <label for="cContact" class ='col-md-3'>Contact Name: </label>
                        <input type="text" name="cContact" id="cContact">
                    </p>
                    <p class='col-md-6'>
                        <label for="cEmail" class='col-md-3'>Company Email: </label>
                        <input type="rDate" name='cEmail' id='cEmail' >
                    </p>
                    <p class='col-md-6'>
                        <label for="cPhone" class='col-md-3'>Company Phone: </label>
                        <input type="text" name="cPhone" id="cPhone">
                    </p>
                    <p class='col-md-6'>
                        <label for="cFax" class='col-md-3'>Company Fax: </label>
                        <input type="text" name='cFax' id='cFax'>
                    </p>
                    <p class='col-md-6'>
                        <label for="cNotes" class='col-md-3'>Notes </label>
                        <textarea form='customerForm' name='cNotes' id='cNotes' cols='35'></textarea>
                    </p>
                    <input type="submit" value="Add customer to Database" onclick='addCustomer()'>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

