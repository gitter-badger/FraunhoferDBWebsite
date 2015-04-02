<!DOCTYPE html>
<?php
  include 'connection.php';
?>
<html>
  <head>
      <title>Fraunhofer CCD</title>
      <link href='css/bootstrap.min.css' rel='stylesheet'>
      <link href='css/main.css' rel='stylesheet'>
      <script type="text/javascript" src='js/passScript.js'></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

      <script src='js/bootstrap.min.js'></script>

  </head>
  <body>
    <div class='navbar navbar-default navbar-static-top'>
          <div class='container'>
            <a href='index.php' class='navbar-brand'>Home Page</a>
            <ul class='nav navbar-nav navbar-right'>
              <li><a href='adminView.php'>Admins</a></li>
              <li><a href='addOrEdit.html'>Add/edit info</a></li>
            </ul>
          </div>
      </div>

<div class='container'>
       <div class='row well well-lg'>
        <div class='col-md-12'>
          <h2>Choose the right PO number</h2>
            <form><select name='POS' onchange='showTools(this.value);showPOTools()'>
              <option value''>Select a PO#: </option>
          <?php 
                $sql = "SELECT POID FROM POS";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_array($result)){
                 echo '<option value="'.$row[0].'">'.$row[0].'</option>';
              } 
                echo "</select></form>";
          ?>

        <br><div id="txtHint"><b>PO info will be listed here...</b></div>
      </div>
    </div>
  <div class='row well well-lg'>
   <div class='col-md-12'>
      <p class='col-md-4'>
          <input type='submit' class='btn btn-danger' name='addTool' value='Delete this PO?' onclick='delPO()'>
      </p>
</div>
</div>
</div>
      </body>
</html>