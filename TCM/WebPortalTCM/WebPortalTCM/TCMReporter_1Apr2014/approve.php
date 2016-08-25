<?php
	//session_start();
	//echo "mylogin: ".$_SESSION['mylogin'] ;
	//echo "priv: ".$_SESSION['priv'] ;
	//echo "pagepriv: ".$pagePrivValue;
if (!isset($_SESSION['mylogin']) 
	|| $_SESSION['mylogin'] != 'TRUE' ||  $_SESSION['priv'] < $pagePrivValue) {
    unset($_SESSION['mylogin']);
    unset($_SESSION['priv']);
    header('Location: index.php'); 
	//echo "loged out";
	exit;
}
	//echo "loged in";
	//echo "mylogin: ".$_SESSION['mylogin'] ;
	//echo "priv: ".$_SESSION['priv'] ;
	//echo "pagepriv: ".$pagePrivValue;
header('Content-Type: text/html; charset=utf-8');
?> 
