<?php
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {
	
	header("Location: index.php");
	exit();	
}   

?>
