<?php

require 'Textile.php';
$t = new Textile();
echo $t->process(file_get_contents($src));
