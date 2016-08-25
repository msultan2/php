<?php
$dbc=mysql_connect('172.23.201.51','DualSIM','DualSIM');
if (!$dbc) { echo("ERROR: " . mysql_error() . "\n");	}
mysql_select_db("DualSIM");
?>