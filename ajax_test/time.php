<?php
 // Заголовок станицы с кодировкой
header('Content-Type: text/html; charset=UTF-8');
 // Выводим время
echo 'Время - '.date('l jS \of F Y h:i:s A');
 // Выводим принятое
echo 'Вы ввели - '.$_POST['url'];
?>