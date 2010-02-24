<?php
require 'markdown.php';
echo Markdown(file_get_contents($src));
