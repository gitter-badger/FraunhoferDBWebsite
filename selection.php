<!DOCTYPE html>
<html>
<head>
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
  <title>Fraunhofer CCD</title>
  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='Views/feedback.php'><strong>Comment</strong></a></li>
        <li><a href='Login/login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>
        <!-- TODO make user profile site?? maybe not useful at all -->
      </ul>
    </div>
  </div>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-3'>
        <form action="Views/overview.php">
          <input type="submit" class='btn btn-primary' value="Tooling overview">
        </form>
      </div>
      <?php 
      if($user_sec_lvl >= 2){
        echo 
        "<div class='col-md-3'>
        <form action='Views/checkin.php'>
        <input type='submit' class='btn btn-primary' value='Check in tools'>
        </form>
        </div>";
      }
      ?>

      <?php 
      if($user_sec_lvl >= 1){
        echo 
        "<div class='col-md-3'>
        <form action='Views/addOrEdit.php'>
        <input type='submit' class='btn btn-primary' value='General information'>
        </form>
        </div>";
      }
      ?>
      <?php
      if($user_sec_lvl >= 4){
        echo
        "<div class='col-md-3'>
        <form action='index'.php'>
        <input type='submit' class='btn btn-primary' value='Finincial data...later'>
        </form>
        </div>";
      }
      ?>
    </div>
  </div>
</body>
</html>
