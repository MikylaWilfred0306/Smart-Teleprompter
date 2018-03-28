<?php 

$pageTitle = "Create User";
$verification = 0;
 include ('header.php'); 
 
 $first_name = $last_name = $email = $pass1 = $pass2 = $position = '';

if (isset($_POST['submit'])) {
	
	// Assume invalid values:
	$first_name = $last_name = $email = $pass1 = $position = FALSE;
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['first_name'])) {
		$first_name = mysqli_real_escape_string ($dbc, $_POST['first_name']);
	} else {
		echo "<div class='error'>Please enter your first name!</div> ";
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['last_name'])) {
		$last_name = mysqli_real_escape_string ($dbc, $_POST['last_name']);
	} else {
		echo "<div class='error'>Please enter your last name!</div> ";
	}
	
	// Check for an email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		echo "<div class='error'>Please enter your email address!</div> ";
	}

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
	
	
	// Check for a job title:
	if (!empty($_POST['position'])) {
		$position = mysqli_real_escape_string ($dbc, $_POST['position']);
	} else {
		echo "<div class='error'>Please enter a position!</div> ";
	}
	
	// Check for a company:
	$company = mysqli_real_escape_string ($dbc, $_POST['company']);
	
	
	if ($first_name && $last_name && $email && $pass1 && $position) { // If everything's OK...
		$q = "SELECT User_Id FROM users WHERE email = '$email'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0) {

			// Create the activation code
			$a = md5(uniqid(rand(), true));
			$incharge = 0;
			
			$q_company = "SELECT Company_Id FROM company WHERE UPPER(Company_Name) = '". strtoupper($company) . "'";
			$r_company = mysqli_query ($dbc, $q_company) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
					if (mysqli_num_rows($r_company) < 1) {
						
					//Check if company exists and add to dropdown and make this user the head of it
					echo $q = "INSERT INTO `company`(`Company_Name`) VALUES ('". $company . "')";
					$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
					
					$q_company = "SELECT Company_Id FROM company WHERE UPPER(Company_Name) = '". strtoupper($company) . "'";
					$r_company = mysqli_query ($dbc, $q_company) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
					$incharge = 1;
					} 
			
			
				// Get the user's information:
				$row_company = mysqli_fetch_array ($r_company, MYSQLI_NUM);
			
			
			$q = "INSERT INTO users (
				First_Name, 
				Last_Name, 
				Email, 
				Password, 
				Belongs_To, 
				In_Charge_Of_Company,
				Verification_Code,
				Position
				) 
			VALUES (
				'$first_name',
				'$last_name',
				'$email',
				SHA1('$pass1'),
				'$row_company[0]',
				'$incharge',
				'$a',
				'$position')";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if ($r) { 	
					
				
					
				
								
				$q_login = "SELECT * FROM `users` Left Join company on Company_Id = Belongs_To WHERE email='$email' AND password=SHA1('$pass1')";	
				$r_login = mysqli_query ($dbc, $q_login) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
				$row_login = mysqli_fetch_array ($r_login, MYSQLI_NUM);
				
				
				$_SESSION['user_email'] = strtolower($email);
				$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				
					// Create the form:
				$_SESSION['name']=$row_login[3] . " " . $row_login[4];
				$_SESSION['id']=$row_login[0];
				$_SESSION['Font_Pref']= $row_login[5];
				$_SESSION['Font_Size_Pref']= $row_login[6];
				$_SESSION['Font_Color_Pref']= $row_login[7];
				$_SESSION['Background_Color_Pref']= $row_login[8];
				$_SESSION['Belongs_To']= $row_login[14];
				$_SESSION['In_Charge_Of_Company']= $row_login[11];
				$_SESSION['Verification_Code']= $row_login[12];
				
				
				$body = "Hello $first_name $last_name.  You have been registered for use at the Smart Teleprompter. To verify email, please click on this link:\n\n";
					$body .= "http://smart-teleprompter.com/verification.php?a=" . $a . "&id=". $row_login[0] . " \n\n";
					$body .= "User name: ". $email."\n";
					$body .= "Password: ". $pass1;
					mail($email, 'Smart Teleprompter Registration', $body, 'From: mikyla.wilfred@gmail.com');

				echo "<div class='success'><strong>Thank you for registering!</strong> A confirmation email has been sent to ".$email.". </div> ";
				
				
				echo "<a href='new_File.php'><button type='button'>Create a new file</button></a>";
				include ('footer.php');
				exit(); 
				
			} else { echo "<div class='error'>You could not be registered due to a system error. We apologize for any inconvenience.</div> ";
			}
			
		} else { 
			echo "<div class='error'>That email has already been registered.</div> ";
		}
		
	} else { 
		echo "<div class='error'>Please try again.</div> ";
	}


} // End of the main Submit conditional.
?>


<script> 	
	function NewCompany()
        {
        var person=prompt("Add this company to the drop down list","Smart Teleprompter");
		var x = document.getElementById("company");
		var option = document.createElement("option");
		option.text = person;
		x.add(option,x[0]);
		x.selectedIndex=0;
		$("#company").trigger("chosen:updated");
        }
	
	
	
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
	
	
	</script>
		
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
function popupFunc() {
    var popup = document.getElementById("pass1pop");
    popup.classList.toggle("show");
}

</script>


		<div class="formHolder">
		<div class="header"> <h1> Create User </h1> </div>
		
			<form class="form" action="createuser.php" method="post">
			
			
			  <div class="labeler">Email </div>
			  <input name="email" class="textbox" type="text" value="<?php echo $email?>"  placeholder="Email">
			
			<br>
			<br> 
			
			<div class="labeler"> First Name</div>
			  <input name="first_name" class="textbox" type="text" value="<?php echo $first_name?>"  placeholder="First Name">
			
			<br>
			<br> 
			
			<div class="labeler"> Last Name</div>
			  <input name="last_name" class="textbox" type="text" value="<?php echo $last_name?>"  placeholder="Last Name">
			
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
			
			
			<div class="labeler"> <a href="#" id="myID" onClick="NewCompany()"><img src="knobs/PNG/Knob Add.png" alt="Add" height="15" width="15"></a> Company </div> 
	  
 

    
			  <?php 
               
					$q = "SELECT Company_Name FROM company ORDER BY Company_Name ASC";
					$r = mysqli_query($dbc, $q);
					
					echo '<select id="company" name="company" class="textbox_dd"> ';
					
					if (!empty($company)) {
					echo '<option value="'.$company.'" selected>'.$company.'</option>\n';
					}
					
					echo '<option></option>';
					while($row = mysqli_fetch_array($r)) {
						echo '<option value="'.$row['Company_Name'].'">'.$row['Company_Name'].'</option>\n';
					}
					echo '</select>';
				
			?>

			<br>
			<br>


			<div class="labeler"> Company Position</div>
			  <input name="position" class="textbox" type="text" value="<?php echo $position?>"  placeholder="Company Position">
		   
			<br>
			<br>
				<input type="hidden" name="submitted" value="TRUE" />
			  <button type="submit" name="submit"> Create</button>

			</form>
		</div>
 <?php include ('footer.php'); ?>