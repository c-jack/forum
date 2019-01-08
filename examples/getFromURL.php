<?php

$html = file_get_contents('http://stackoverflow.com/');
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$nodes = $xpath->query('//*[@class="-logo js-gps-track"]');
foreach($nodes as $href) {
    echo $href->getAttribute( 'href' );
}
