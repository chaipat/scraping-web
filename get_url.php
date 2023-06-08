<?php

include_once('./simple_html_dom.php');

$html = file_get_html('https://www.google.com/');

foreach($html->find('img') as $element)
    echo $element->src . '<br>';

echo "<hr>";

foreach($html->find('a') as $element)
    echo $element->href . '<br>';
echo "<hr>";



?>