<?php
error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('allow_url_fopen', 'Off');

session_start();
$uploaded_path =  dirname(__FILE__).'/uploads/';

$book_list = array();
$iterator = new DirectoryIterator("glob://".$uploaded_path."*");
foreach ($iterator as $eachbook) $book_list[] = $eachbook->__toString();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>LIBRARY - HCTF</title>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
    <style>
      .mui--appbar-height a {
        color: white;
      }
    </style>
  </head>
  <body>
    <div class="mui-appbar">
      <table width="100%">
        <tr style="vertical-align:middle;">
          <td class="mui--appbar-height"> Welcome to Aklis's Library   <?=$_SESSION['username'];?></td>
          <?php if (isset($_SESSION['username'])): ?>
          <td class="mui--appbar-height"><a href="/manager.php">Manager</a></td>
          <td class="mui--appbar-height"><a href="/logout.php">Logout</a></td>
          <?php else: ?>
          <td class="mui--appbar-height"><a href="/login.php">Login</a></td>
          <?php endif; ?>
        </tr>
      </table>
    </div>
    <div class="mui--text-center">
      <table class="mui-table mui-table--bordered">
        <thead>
          <tr>
            <th>Book Name</th>
          </tr>
        </thead>
        <tbody>
            <?php
              foreach($book_list as $eachbook) {
                echo "<tr><td><a href='/read.php?bookname=$eachbook' >".$eachbook."</a></td></tr>";
              } 
            ?>
        </tbody>
      </table>
    </div>
  </body>
</html>