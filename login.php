<?php
include("config.php");
include("comm.php");

if (isset($_COOKIE['username']) && decrypt($_COOKIE['username'])!=="") {
  $_SESSION['username'] = decrypt($_COOKIE['username']);
  header("Location: /index.php");
  exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
  if ($_POST['username']==='' || $_POST['password']==='' || $_POST['gogogo']!=='苟!')
  {
    exit("搞事搞事搞事.jpg");
  }

  $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

  $username = $mysqli->escape_string($_POST['username']);
  $password = sha1($_POST['password']);
  
  if ($mysqli->connect_errno) {
    exit("噗".$mysqli->error);
  }
  
  if($result = $mysqli->query("select * from users where username='$username' and password='$password'")) {
    if ($result->num_rows === 1) {
      $row = $result->fetch_array();
      setcookie('username', encrypt($row['username']));
      $_SESSION['username'] = $row['username'];
      header("Location: /index.php");
    } else {
      exit("用户名或密码错误 QAQ");
    }
  }

}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>LIBRARY - HCTF</title>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <form action="" method="POST">
      <legend>Log in   - <a href='/register.php'>Register</a></legend>
      <div class="mui-textfield">
        <input type="text" placeholder="Username" name="username">
      </div>
      <div class="mui-textfield">
        <input type="password" placeholder="Password" name="password">
      </div>
      <input type="submit" class="mui-btn mui-btn--raised" name="gogogo" value="苟!" ></button>
    </form>
  </body>
</html>
