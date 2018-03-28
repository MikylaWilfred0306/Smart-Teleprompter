<?php 

$pageTitle = "Verification Email";
$verification = 0;

 include ('header.php'); 
 include ('login_header.php'); 
	$body = "Hello " . $_SESSION['name'] . " To verify email, please click on this link:\n\n";
	$body .= "http://smart-teleprompter.com/verification.php?a=" . $_SESSION['Verification_Code'] . "&id=".  $_SESSION['id'] . " \n\n";
	mail($_SESSION['user_email'], 'Smart Teleprompter Registration', $body, 'From: mikyla.wilfred@gmail.com');

	echo "<br><br><div class='success'><strong>Your verification email has been sent again to ".$_SESSION['user_email'].".</strong> </div> ";

 include ('footer.php'); ?>


