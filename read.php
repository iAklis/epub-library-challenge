<?php
include("config.php");
$uploaded_path =  dirname(__FILE__).'/uploads/';

$book_name = trim($_GET['bookname']);
$book_path = $uploaded_path . $book_name . '/';

if (!is_dir($book_path))
{
  exit('(ಥ_ಥ) Aklis还没有这本书');
}

libxml_disable_entity_loader(false);
$container_info = simplexml_load_file($book_path . '/META-INF/container.xml', 'SimpleXMLElement', LIBXML_NOENT);
$source_file = $container_info->rootfiles->rootfile["full-path"];

$container_info = simplexml_load_file($book_path . $source_file, "SimpleXMLElement", LIBXML_NOENT);
$ebook_info = $container_info->metadata;

$manifest = (array)$container_info->manifest;
$meta_title = $ebook_info->{"meta"}["content"];

foreach ($manifest["item"] as $key => $value) {
  foreach((array)$value as $attr => $attr_value) {
    if($attr_value["media-type"] === "application/x-dtbncx+xml") {
      $ncx_file = $attr_value["href"];
    }
  }
}

$index = simplexml_load_file(dirname($book_path . $source_file)."/". $ncx_file, "SimpleXMLElement", LIBXML_NOENT);
$title = $index->docTitle->{'text'};
$navMap = $index->navMap->{'navPoint'};
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?=$title;?> -- INDEX</title>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="mui-appbar">
      <table width="100%">
        <tr style="vertical-align:middle;">
          <td class="mui--appbar-height">Hello, <?=$_SESSION['username'];?></td>
          <td class="mui--appbar-height" align="right"><a href="/login.php">Login</a></td>
        </tr>
      </table>
    </div>
    <table class="mui-table mui-table--bordered">
      <thead>
        <tr>
          <th><?=$title;?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($navMap as $key => $value) {
            $iter =  $value->{'navLabel'}->{'text'};
            echo "<tr><td><a href=\"/uploads/".$book_name.'/'.dirname($source_file).'/'.$value->{'content'}['src']."\">$iter</a></th></td>";
          } 
        ?>
      </tbody>
    </table>
</body>
</html>