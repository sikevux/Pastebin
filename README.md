Simple Pastebin
===============

By zash
<http://zash.se/>

and hacked by Sikevux
<http://sikevux.se/>

Zash's code is used here: <http://p.zash.se/>

Sikevux's code is used here: <http://c0re.se/>

Consider this to be in the public domain. You are free to do whatever you want
with this. I do not consider it big enough to license under GPL or similar.

Included files
--------------

* `index.html`
	a form for posting to the pastebin
* `catch.php`
	recives and stores the paste
* `error-handler.php`
	for auto-completion like behaviour and php-code highlighting
* `crontab`
	a crontab entry for cleaning up pasted files
* `pastebin`
	a bash script for uploading data to pastebin
* `README.md`
	this file

Installation
------------

0. Install pdflatex
1. Create a new subdomain or directory on your webserver (not included).
2. Place the `catch.php` files and `index.html` in there. You can rename `index.html` if you want.
3. `chmod webbserver+w` on the directory.
4. If you want filename completion and syntax highlighting, configure your webserver to let `error-handler.php` handle 404's.
5. Add the crontab-row to your crontab and edit the path if you want automagic cleanup.
6. If you want to use the pastebin bash script, edit it and change `$RECIVER_URL` to match your setup or put `RECIVER_URL=http://yourpastebin/catch.php` in `~/.pastebinrc`.
