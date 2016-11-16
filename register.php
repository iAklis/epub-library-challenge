<?php
include("config.php");

if ($_SESSION['username']!=='') {
  header('Location: /index.php');
  exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
  
  // vaild_code

  if ($_POST['username']==='admin') {
    exit('Aklis is admin! 你想干啥？');
  }

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
  
  if($result = $mysqli->query("select * from users where username='$username'")) {
    if ($result->num_rows) {
      $result->close();
      echo "用户已存在";
    } else {
      $query = "insert into users values (NULL, '$username', '$password', '');";
      if ($mysqli->query($query)===TRUE) {
        $mysqli->close();
        header("Location: /login.php");
      } else {
        exit("服务器炸了！".$mysqli->error);
      }
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
      <legend>Register</legend>
      <div class="mui-textfield">
        <input type="text" placeholder="Username" name="username">
      </div>
      <div class="mui-textfield">
        <input type="text" placeholder="Password" name="password">
      </div>
      <input type="submit" class="mui-btn mui-btn--raised" name="gogogo" value="苟!" ></button>
    </form>
  </body>
</html>