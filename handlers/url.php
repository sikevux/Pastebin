<?php

$data = trim(file_get_contents($src));
if(preg_match('/\r\n?|\n/', $data))
	list($data) = preg_split('/\r\n?|\n/', $data, 1,  PREG_SPLIT_NO_EMPTY);
if(!preg_match('/^https?:\/\/.*$/', $data)) {
	header('HTTP/1.1 302 Found');
	header('Location: ' .  $src);exit;}
require 'markdown.php';
echo Markdown('<'.$data.'>');
