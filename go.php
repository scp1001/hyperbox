<?php 

//putenv("PATH=" .$_ENV["PATH"]. ':/root/all/bin');
//putenv("Z3_LIB_DIRS" .$_ENV["PATH"]. ':/var/www/html/all/bin/libz3.so');

//file_put_contents('code.txt', $_POST['code']);

//file_get_contents('http://2.59.42.98/hyperbox.php');

//putenv('PATH=/var/www/html/all/bin');
print  shell_exec("/usr/bin/python /var/www/html/all/bin/python/code.py");