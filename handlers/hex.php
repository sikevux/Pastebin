<?php

header('Content-Type: text/plain');
echo shell_exec(sprintf('hexdump -C %s', escapeshellarg($src)));
