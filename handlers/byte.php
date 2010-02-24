<?php
header('Content-Type: text/plain');
echo shell_exec(sprintf('hexdump -c %s', escapeshellarg($src)));
