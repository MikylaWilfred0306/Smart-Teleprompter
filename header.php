<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'container');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'x_test_teleprompter');


// Make the connection:
		$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
?>
		<!DOCTYPE html>
<html lang="en">
<head>	
	<link rel="shortcut icon" href="logo/icon.jpg">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<link rel="stylesheet" type="text/css" href="main.css">
	<script src="functions.js"></script>
	<title><?php 
	/*
http://www.color-hex.com/color/6c2c2c 

http://www.color-hex.com/color/f0f0f0 
*/
echo $pageTitle; ?></title>
	
</head>
<body>
<div class="content">
  <div class="content-inside">
	
		
<?php
session_start(); // Access the existing session.



if ((!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) or $pageTitle == "Log Out") {
	?>
	<div class="bannerHolder">
	
		
	<ul  class ="navul2">
	 <li class ="navli2"><a href="index.php"><img src="logo/banner.jpg" style="height:75px;"></a></li>
		 <li class ="navli2" style="float:right; padding:25px 10px"><a href="login.php">Login</a></li>
		</ul>
	<ul  class ="navul">
	  <li class ="navli"><a href="index.php">Home</a></li>

	</ul>
	 </div>
<?php	
}	else { ?>

<div class="bannerHolder">
	
		
	<ul  class ="navul2">
	 <li class ="navli2"><a href="index.php"><img src="logo/banner.jpg" style="height:75px;"></a></li>
		 <li class ="navli2" style="float:right; padding:25px 10px"><a href="logout.php">Logout</a></li>
		</ul>
	<ul class ="navul">
	    <li class ="navli"><a href="index.php">
		<?php //Change Style
		echo "Hello ". $_SESSION['name']  ." from ". $_SESSION['Belongs_To'] ."!"; 

			?></a>
		</li>

		<li class="dropdown">
		<a href="files.php" class="dropbtn">Files</a>
		<div class="dropdown-content">
		  <a href="files.php">View Files</a>
		 <a href="new_File.php">New File</a>
		<a href="upload_File.php">Upload File</a>
		</div>
	  </li>

	 <li class="dropdown">
		<a href="edituser.php" class="dropbtn">Profile</a>
		<div class="dropdown-content">
		  <a href="edituser.php">Edit User</a>
		  <a href="changepassword_internal.php">Change Password</a>
		  <a href="timer.php">Read Time</a>
		</div>
	  </li>
	</ul>
	 </div>
	<?php
	// Verified or not 
	if ($_SESSION['Verification_Code'] != '1' && $verification == 1){
		
			echo "<div class='warning'>Please verify your email. <a href='verification_again.php'><button type='button'>Send Again?</button></a></div> "; 
		
	}
	
}
 ?> 


<br>