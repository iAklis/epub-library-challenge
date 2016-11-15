<?php
error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('allow_url_fopen', 'Off');

$uploaded_path =  dirname(__FILE__).'/uploads/';

$book_list = array();
$iterator = new DirectoryIterator("glob://".$uploaded_path."*");
foreach ($iterator as $eachbook) $book_list[] = $eachbook->__toString();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div class="mui-container mui--text-center">
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit" class="mui-btn mui-btn--flat mui-btn--primary"/>
      </form>
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