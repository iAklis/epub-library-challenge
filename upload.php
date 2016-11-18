<?php
include("config.php");
if ($_SESSION['username']!=='admin') {
  echo "你不是我的admin!";
  exit();
}

//upload
$files = isset($_FILES['file']) ? $_FILES['file'] : exit();
if($files['type']!=="application/epub+zip") {
  exit("Not Allow type!");
}

//extract
$file = new ZipArchive;
$epub_name = $files['tmp_name'];
$extracted_path = 'uploads/'.basename($files['name'],".epub")."/";
if ($file->open($epub_name) === TRUE){
  $file->extractTo($extracted_path);
  $file->close();
}

//xmlparse
libxml_disable_entity_loader(false);
$container_info = simplexml_load_file($extracted_path."META-INF/container.xml", 'SimpleXMLElement', LIBXML_NOENT);
$source_file = $container_info->rootfiles->rootfile["full-path"];

$container_info = simplexml_load_file($extracted_path.$source_file, "SimpleXMLElement", LIBXML_NOENT);
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

$index = simplexml_load_file(dirname($extracted_path.$source_file)."/".$ncx_file, "SimpleXMLElement", LIBXML_NOENT);

$title = $index->docTitle->{'text'};
$navMap = $index->navMap->{'navPoint'};

?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$title;?>介绍</title>
    <meta charset="UTF-8">
    <link href="static/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
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
            echo "<tr><td><a href=\"".$extracted_path.dirname($source_file).'/'.$value->{'content'}['src']."\">$iter</a></th></td>";
          } 
        ?>
      </tbody>
    </table>
</body>
</html>
