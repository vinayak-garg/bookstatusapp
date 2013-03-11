<?php

$connection = mysql_connect('localhost', 'root', 'mysqlroot')or die('cannot connect');
mysql_select_db('bookstatus', $connection)or die('cannot select DB');

?>
