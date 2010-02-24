<?php

echo '<font face="Comic Sans MS">';
echo nl2br(htmlspecialchars(file_get_contents($src)));
