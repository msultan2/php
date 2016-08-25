<?php


/* Database config */

$db_host		= 'CNPVAS04';
$db_user		= 'Reader';
$db_pass		= 'Reader';
$db_database	= 'NotesTool';

/* End config */



$link = mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>