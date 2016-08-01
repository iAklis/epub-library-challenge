<!DOCTYPE html>
<html>
  <head>
    <title>EPUB之家</title>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="mui--text-center">
      <div class="mui--appbar-height">
        <div class="mui--text-display3">
          E · P · U · B
        </div>
      </div>
    </div>
    <hr >
    <div class="mui-container mui--text-center">
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit" class="mui-btn mui-btn--flat mui-btn--primary"/>
      </form>
    </div>
  </body>
</html>