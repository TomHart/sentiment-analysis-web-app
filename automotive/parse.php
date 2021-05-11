<?php
declare(strict_types=1);

$file = $argv[1];

$content = file_get_contents($file);

$content = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $content);
$content = preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $content);


$xml = simplexml_load_string($content);

if(file_exists($file . '.txt')){
    unlink($file . '.txt');
}

$file = fopen($file . '.txt', 'wb');
foreach($xml->review as $review){
    fwrite($file, str_replace(PHP_EOL, '', $review->review_text->__toString()) . PHP_EOL);
}
fclose($file);
