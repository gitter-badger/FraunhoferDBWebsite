<!DOCTYPE html>
 <?php
  include '../connection.php';
?>

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
    <a href='../selection.php'>Take me home</a>
    <h2>Place for feedback</h2>
    <h5>please be gentle</h5>
    <h6>I have feelings</h6>
      <form action="addFeedback.php" method="post">
        <h3>Name:</h3> <input type="text" name="name"><br>
        <h3>Feedback:</h3><textarea name="comment"></textarea><br>
        <input type="submit">
      </form>
  </div>
  <div class='col-md-12'>
    <h2>These are all the comments</h2>
    <?php 

      $sql = "SELECT * FROM Feedback";
      $result = mysqli_query($link, $sql);

      while($row = mysqli_fetch_array($result)){
        echo "<div class='row well well-lg'>".$row[0]."<div><strong>".$row[1]."</strong></div><div>". $row[2]."</div></div>";
      }

    ?>
  </div>
</body>
</html>