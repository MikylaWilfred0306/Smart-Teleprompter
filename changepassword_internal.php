<?php 

$pageTitle = "Change password";
$verification = 0;
 include ('header.php'); 
 $pass1 = $pass2 = $old = '';
 if (isset($_POST['submit'])) {
	
	// Assume invalid values:
	 $pass1 = FALSE;

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/m', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$pass1 = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			echo "<div class='error'>Your passwords do not match!</div> ";
		}
	} else {
		echo "<div class='error'>Please enter a valid password!  Must be at least 8 characters and less than 25. It must have an uppercase and lowercase letter. There must also be a number and symbol.</div> ";
		
	}
	
	if (!empty($_POST['old'])) {
		$old = mysqli_real_escape_string ($dbc, $_POST['old']);
	} else {
		echo "<div class='error'>Please enter an old password!</div> ";
	}
	
	
	
	if ($pass1 && $old) { // If everything's OK...
		$q = "SELECT User_Id FROM users WHERE email = '".$_SESSION['user_email']."' and `Password`=SHA1('$old')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 1) {

			$incharge = 0;
			
			$q = "UPDATE `users` SET `Password`=SHA1('$pass1')  WHERE  User_Id = '".$_SESSION['id']."' ";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if ($r) { 	
					
				echo "<div class='success'>Password is changed. </div> ";
				
				
				echo "<a href='index.php'><button type='button'>Home</button></a>";
				include ('footer.php');
				exit(); 
				
			} else { 
			echo "<div class='error'>You could not be registered due to a system error. We apologize for any inconvenience.</div> ";
			}
			
		} else { 
			echo "<div class='error'>The old password is incorrect</div> ";
		}
		
	} else { 
		echo "<div class='error'>Please try again.</div> ";
	}


} // End of the main Submit conditional.
?>

 
 		
<style>
/* Popup container - can be anything you want */
.popup {
    position: relative;
    display: inline-block;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 300px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: -50%;
    left: 135%;
    margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::after {
    content: " ";
    position: absolute;
    top: 50%;
    right: 100%; /* To the left of the tooltip */
    margin-top: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent black transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}
</style>

 
 <script>

	function checkPassword()
	{
		var js_pass1 = document.getElementById("pass1").value;
		
			document.getElementById("matcher").value = js_pass1;
		var js_pass2 = document.getElementById("pass2").value;
		
		if (js_pass1 == js_pass2){
			document.getElementById("matcher").value = "Yes!";
			document.getElementById("matcher").style.backgroundColor = "green";
			document.getElementById("matcher").style.color = "white";
		}else{
			document.getElementById("matcher").value = "No!";
			document.getElementById("matcher").style.backgroundColor = "red";
			document.getElementById("matcher").style.color = "white";
		}
		
	}
	
	function popupFunc() {
    var popup = document.getElementById("pass1pop");
    popup.classList.toggle("show");
}
	</script>
 
 
 <br> 
		<br> 
		<br> 
		<div class="formHolder">
		<div class="header"> <h1>Change Password </h1> </div> 
		
			<form class="form" action="" method="post">
			
			
			  <div class="labeler"> Old Password</div>
			  <input name="old" class="textbox" type="Password" value="<?php echo $old?>" placeholder="Old Password">
			
				<br>
			<br>
			
		
			 <div class="labeler tooltip"> Password   </div>
		<div class="popup">	 <span id="pass1pop" class="popuptext"> Must be at least 8 characters and less than 25. It must have an uppercase, lowercase letter, a number, and a symbol.</span>	
			  <input name="pass1" id="pass1"  onFocus="popupFunc()" onBlur="popupFunc();" onChange="checkPassword();" class="textbox popup" type="password" value="<?php echo $pass1?>"  placeholder="Password">
	</div>
   
			<br>
			<br>

			<div class="labeler"> Confirm Password </div>
			  <input name="pass2" id="pass2" class="textbox" onChange="checkPassword();" type="password" value="<?php echo $pass2?>"  placeholder="Confirm Password">
		   
			<br>
			<br>
			
			<div class="labeler"> Do the passwords match? </div>
			  <input name="matcher"  id="matcher" class="textbox" type="text" placeholder="Match" readonly>
		   
			<br>
			<br>
			 

			<input type="hidden" name="submitted" value="TRUE" />
		
			<br>
			<br>
			
			  <button type="submit" name="submit"> Change Password</button>

			</form>
		</div>
  <?php include ('footer.php'); ?>