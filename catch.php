<?php
/* catch.php
 * simple pastebin-like thingy
 * shorter filename mod (b64+crc32)
 * antispam patch
 * by Zash
 */

if(!empty($_POST['text'])) {
	if($sh = dns_get_record(implode('.', array_reverse(explode('.', $_SERVER['REMOTE_ADDR']))).'.sbl-xbl.spamhaus.org', DNS_A) and !empty($sh)) {
		header('HTTP/1.1 405 Spam Not Allowed');
		exit('Spammer begone!'); }
	$file = strtr(rtrim(base64_encode(pack('N', crc32($data = $_POST['text']))),'='),'/+','_-') . '.txt';
	$filepath = dirname(__FILE__) . DIRECTORY_SEPARATOR . $file;
	$url = realpath(dirname($_SERVER['SCRIPT_NAME']) . "/$file");
	if(!file_exists($filepath)) {
		if(file_put_contents($filepath, $data) !== false) {
			header('HTTP/1.1 201 Created');
			header('Content-Type: text/plain');
			header('Location: ' . $url);
			header('Refresh: 1; URL=' . $url);
			echo "http://{$_SERVER['HTTP_HOST']}$url\n";
			error_log("pastebin: $file uploaded from {$_SERVER['REMOTE_ADDR']}", 0);
		} else {
			header('HTTP/1.1 500 Internal Server Error');
			echo 'Could not open file for writing'; }
	} else {
		header('HTTP/1.1 409 Conflict');
		header('Refresh: 1; URL=' . $url);
		echo "File exists: http://{$_SERVER['HTTP_HOST']}$url\n"; }
} else {
	header('HTTP/1.1 303 See Other');
	header('Location: /');
	echo 'No input data'; }
