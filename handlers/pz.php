<?php

echo '<code>';#<pre>';
if($tokens = token_get_all(file_get_contents($src))) {
	$last_token = null;
	$last_line = 0;
	foreach($tokens as $token) {
		if(!is_array($token)) {
			$token = array(0, $token, $last_line);
		}
		switch(token_name($token[0])) {
		case 'T_WHITESPACE':
			printf(
				'<span class="%s">%s</span>',
				token_name($token[0]), 
				nl2br(
					strtr($token[1],
					array(
						"\t" => "<span class=\"K_TAB\">&nbsp;&nbsp;&nbsp;</span>",
						" " => "&nbsp;",
					))));
			break;

		case 'UNKNOWN':
			printf('<span class="K_%s">%s</span>', ord($token[0]), htmlentities($token[1]));
			break;

		default:
			printf('<span class="%s">%s</span>', token_name($token[0]), htmlentities($token[1]));
			break;
		}
		$last_token = $token[0];
		$last_line = $token[2];
	}
} else {
	echo ":(";
}
echo '</code>';
#echo '</pre></code>';
