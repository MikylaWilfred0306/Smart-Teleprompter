<?php 
ob_start();
$pageTitle = "Log Out";
$verification = 0;
 include ('header.php'); 
include ('login_header.php'); 
function absolute_url ($page = '') {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;
	return $url;
} 

if (!isset($_SESSION['user_email'])) {
	$url = absolute_url();
	header("Location: $url");
	exit();
} else {
	$_SESSION = array();
	session_destroy();
	setcookie ('PHPSESSID', '', time()-28800, '/', '', 0, 0);

}

?>
		<br> 
		<br> 
<div class="formHolder">
	
		<div class="header"> <h1>Logged Out! </h1> </div> 
		<div class="labeler"><p>You are now logged out!</p> </div>
	<a href="login.php"><button type="button">Log back in</button></a>
	

	</div>
 <?php include ('footer.php'); ?>
<?php 
ob_end_flush();
?>

