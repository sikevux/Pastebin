<?php
# For the purpose of annoying people who hate Comic Sans

echo '<font face="Comic Sans MS">';
echo nl2br(htmlspecialchars(file_get_contents($src)));
