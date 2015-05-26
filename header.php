  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='../selection.php' class='navbar-brand'>Home</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='../Views/feedback.php'><strong>Comment</strong></a></li>
        <li><a href='../Login/login.php'>Log in or change user</a></li>
        <li style='margin-top:15px;padding-right:10px;'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>
        <!-- TODO make user profile site?? maybe not useful at all -->
      </ul>
    </div>
  </div>