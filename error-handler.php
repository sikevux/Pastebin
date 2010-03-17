<?php # error-handler.php, by Zash. Part of simple pastebin-thingy.

ob_start('ob_gzhandler');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$ext = pathinfo($uri, PATHINFO_EXTENSION);
$src = '.' . substr_replace($uri, 'txt', -strlen($ext));
if(file_exists($src)) {
	header('Content-Type: text/html; charset=utf8');
	switch($ext) {
	case 'php': # php-syntax highlighting
		highlight_file($src);
		break;

	case 'text':
		echo nl2br(htmlspecialchars(file_get_contents($src)));
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

# FIXME This only works on my server.
# Is there any way to trigger the local webservers native error page?
header('HTTP/1.1 404 Not Found');readfile('/home/www/status/404.html');
