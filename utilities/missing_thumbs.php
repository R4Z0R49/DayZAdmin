<?php
$xml = file_get_contents('items.xml', true);
require_once('modules/xml2array.php');
$items_xml = XML2Array::createArray($xml);

foreach(array_keys($items_xml['items']) as $item) {
    $item = ltrim($item, "s");
    $thumb = "images" . DIRECTORY_SEPARATOR . "thumbs" . DIRECTORY_SEPARATOR . $item . ".png";
    if(!file_exists($thumb)) {
        printf("%s\n", $item);
    }
}
?>
