<!DOCTYPE html>
<?php
  include '../connection.php';
  session_start();
?>
<script type="text/javascript">
var idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 19) { // 20 minutes
        window.location.reload();
    }
}
</script>   
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/passScript.js'></script>
</head>
<body>
  <div class='col-md-12'>
    <?php include '../header.php'; ?>
    <h2>Place for feedback</h2>
    <h3>Name:</h3> <input type="text" id='name'name="name"><br>
    <h3>Feedback:</h3><textarea id='comment'name="comment"></textarea><br>
    <input type="submit" onclick='addFeedback()'>
  </div>
  <div class='col-md-12'>
    <h2>These are all the comments</h2>
    <?php 
    $sql = "SELECT * FROM Feedback ORDER BY FID DESC";
    $result = mysqli_query($link, $sql);
    if(!$result){mysqli_error($link);}
    while($row = mysqli_fetch_array($result)){
      echo "<div class='row well well-lg'>".$row[0]."<div><strong>".$row[1]."</strong></div><div>". $row[2]."</div></div>";
    }
    ?>
  </div>
</body>
</html>