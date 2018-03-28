<?php 

$pageTitle = "Forgot Password";
$verification = 0;
 include ('header.php'); 
 
 function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

 $password = random_password(8);
$email = '';
 
 if (isset($_POST['submit'])) {
	  $email = FALSE;
	 if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		echo "<div class='error'>Please enter your email address!</div> ";
	}
	
	if ($email) { 
	
	
	} else { 
		echo "<div class='error'>Please try again.</div> ";
	} 
 }
 
 
 
 
 
 
 
?>
<div class="formHolder">
		<div class="header"> <h1> Forgot Password </h1> </div>
		
			<form class="form" action="" method="post">
			
			
			  <div class="labeler">Email </div>
			  <input name="email" class="textbox" type="text" value="<?php echo $email?>"  placeholder="Email">
			
			<br>
			<br> 
 	<input type="hidden" name="submitted" value="TRUE" />
			  <button type="submit" name="submit"> Forgot Password</button>

			</form>
		</div>
 
<?php include ('footer.php'); ?>