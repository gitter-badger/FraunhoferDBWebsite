<!DOCTYPE html>
<?php
include 'connection.php';
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='css/main.css' rel='stylesheet'>

  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script type="text/javascript" src='js/passScript.js'></script>
</head>
<body>
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='index.php' class='navbar-brand'>Home Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='adminView.html'>Admins</a></li>
        <li><a href='addOrEdit.html'>Add/edit info</a></li>
      </ul>
    </div>
  </div>
  <div class='container'>
    <div class='row well well-lg'>
      <div class='col-md-12'>
        <h2>Here is a list of all our Coatings</h2>
        <table id="report" class='col-md-12'>
          <tr>
            <th>Machine ID</th>
            <th>Coating type</th>
            <th>Something more?</th>
          </tr>
          <?php
          $sql ="SELECT * 
          FROM Coatings";
          $result = mysqli_query($link, $sql);
          if (!$result){
           die("Database query failed: " . mysql_error());
         }
         while($row = mysqli_fetch_array($result)){
          echo "<tr>".
          "<td>".$row[0]."</td>".
          "<td>".$row[1]."</td>".
          "<td>".$row[2]."</td>".
          "</tr>";

        }


        ?>
      </table>
    </div>
  </div>
</div>
</body>
</html>