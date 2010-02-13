<?php # error-handler.php, by Zash. Part of simple pastebin-thingy.

error_reporting(0);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$ext = pathinfo($uri, PATHINFO_EXTENSION);
$src = '.' . substr_replace($uri, 'txt', -strlen($ext));
if(file_exists($src)) {
	header('Content-Type: text/html; charset=utf8');
	switch($ext) {
	case 'php': # php-syntax highlighting
		highlight_file($src);
		break;

	case 'pz':
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
		break;

	case 'text':
		echo nl2br(htmlspecialchars(file_get_contents($src)));
		break;

#/*
	case 'md':
		require 'markdown.php';
		echo Markdown(file_get_contents($src));
		break;

	case 'tl':
		require 'Textile.php';
		$t = new Textile();
		echo $t->process(file_get_contents($src));
		break;#*/

	case 'hex':
		header('Content-Type: text/plain');
		echo shell_exec(sprintf('hexdump -C %s', escapeshellarg($src)));
		break;

	case 'B': case 'byte':
		header('Content-Type: text/plain');
		echo shell_exec(sprintf('hexdump -c %s', escapeshellarg($src)));
		break;

	case 'url':
		$data = trim(file_get_contents($src));
		if(preg_match('/\r\n?|\n/', $data))
			list($data) = preg_split('/\r\n?|\n/', $data, 1,  PREG_SPLIT_NO_EMPTY);
		if(!preg_match('/^https?:\/\/.*$/', $data)) {
			header('HTTP/1.1 302 Found');
			header('Location: ' .  $src);exit;}
		require 'markdown.php';
		echo Markdown('<'.$data.'>');
		break;

	default:
		header('HTTP/1.1 302 Found');
		header('Location: ' .  $src);exit;}
	exit;}

# autocomplete
if(preg_match('/^\/([-_0-9a-zA-Z]{2,6})/', $_SERVER['REQUEST_URI'], $m))
	if($matching = glob($m[1] . '*.txt') and count($matching) == 1) {
		header('HTTP/1.1 302 Found');
		header('Location: /' .  $matching[0]);
		exit;}

header('HTTP/1.1 404 Not Found');readfile('/home/www/status/404.html');
