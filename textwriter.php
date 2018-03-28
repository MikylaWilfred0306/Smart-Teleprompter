<?php

 $pageTitle = "Text Writer";
$verification = 1;
include ('header.php'); 
include ('login_header.php'); 

if  (isset($_POST['file'] )) {
	$file = $_POST['file'];
} else if  (isset($_GET['file'] )) {
	$file = $_GET['file'];
} else { 
	//$file = 'Scripts/test_script.txt';
	echo "<div class='error'>This page has been accessed in error. </div> <a href='files.php'><button type='button'>Go Back</button></a>";
	exit();
}


if (isset($_POST['text']))
{
	$saved_bool = file_put_contents($file, $_POST['text']);

	if ($saved_bool === false) {

		echo "<div class='error'>Save Failed</div> ";
	} else {
		echo "<div class='success'>Changes Saved</div> ";
	}    
}

// read the textfile
$text = file_get_contents($file);

?>



<script>
	 function doFunction() { 
		var js_Font_Size_Pref = document.getElementById("Font_Size_Pref").value;
		var js_Font_Color_Pref = document.getElementById("Font_Color_Pref").value;
		var js_Font = js_Font_Color_Pref.replace("#", "");
		var js_Background_Color_Pref = document.getElementById("Background_Color_Pref").value;
		var js_Back = js_Background_Color_Pref.replace("#", "");
		var js_Font_Pref = document.getElementById("Font_Pref").value;

		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var booltest = xmlhttp.responseText;
				
				var good = document.getElementById("good");
				var bad = document.getElementById("bad");
				if (booltest == "saved") {
					good.style.display = "block";
				} else {
					bad.style.display = "block";
				}
				
				
			}
		};
		xmlhttp.open("GET","saveDefaults.php?q="+js_Font_Size_Pref+"&r="+js_Font+"&s="+js_Back+"&t="+js_Font_Pref,true);
		xmlhttp.send();
        
	}
	

	
function setFont(str){
	document.getElementById("Font_Pref").style.fontFamily = str;
} 
</script>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script>
        
        $(window).on("beforeunload", function() {
            return "Are you sure? You didn't finish the form!";
        });
        
        $(document).ready(function() {
            $("#myForm").on("submit", function(e) {
                 $(window).off("beforeunload");
                return true;
            });
        });
        </script>



<br>
<div class="teleformHolder">

<form id="myForm" action="" method="post">

<div class="header"> <h1> Edit the Script</h1> </div>
<div class="buttonHolder">
  <button type="submit" name="submit"> Save File</button>
  <button type="reset" name="reset"> Restore to Last Save</button>
</div>

<br>

<textarea rows="30" name="text"><?php echo htmlspecialchars($text) ?></textarea>
<input type="hidden" name="file" value="<?php echo $file ?>" />
<br>
<br>
<br>

<div class="buttonHolder">
  <button type="submit" name="submit"> Save File</button>

  <button type="reset" name="reset"> Restore to Last Save</button>
</div>
</form>
<hr>
<div class="header"> <h1> Teleprompt the Script</h1> </div>
<form action="teleprompter.php" method="post">

<div style="display: none;" id = "good" class='success'>Defaults Saved</div> 
<div  style="display: none;" id = "bad" class='error'>Defaults Saving Failed</div>


<input type="hidden" name="file" value="<?php echo $file ?>" />
<div class="labeler noWrap"> Font Color:</div>
<input name="Font_Color_Pref" id="Font_Color_Pref" class="textbox noWrap" type="color" value="<?php echo $_SESSION['Font_Color_Pref']?>"  >

<div class="noWrap"> &nbsp;&nbsp;</div>

<div class="labeler noWrap"> Background Color:</div>
<input name="Background_Color_Pref" id="Background_Color_Pref" class="textbox noWrap" type="color" value="<?php echo $_SESSION['Background_Color_Pref']?>" >

<div class="noWrap"> &nbsp;&nbsp;</div>


<div class="labeler noWrap"> Font Type: </div>
			  <?php              
					echo '<select id="Font_Pref" name="Font_Pref" class="textbox_dd" onChange="setFont(this.value);"> ';
					
					if (!empty($_SESSION['Font_Pref'])) {
						echo '<option style="font-family: \''.$_SESSION['Font_Pref'].'\'" value="'.$_SESSION['Font_Pref'].'" selected>'.$_SESSION['Font_Pref'].'</option>\n';
					}
					
					echo '<option style="font-family: \'Arial\'" value="Arial">Arial</option>\n';
					echo '<option style="font-family: \'Arial Black\'" value="Arial Black">Arial Black</option>\n';
					echo '<option style="font-family: \'Comic Sans MS\'" value="Comic Sans MS">Comic Sans MS</option>\n';
					echo '<option style="font-family: \'Courier New\'" value="Courier New">Courier New</option>\n';
					echo '<option style="font-family: \'Georgia\'" value="Georgia">Georgia</option>\n';
					echo '<option style="font-family: \'Impact\'" value="Impact">Impact</option>\n';
					echo '<option style="font-family: \'Lucida Console\'" value="Lucida Console">Lucida  Console</option>\n';
					echo '<option style="font-family: \'Lucida Sans Unicode\'" value="Lucida Sans Unicode">Lucida Sans Unicode</option>\n';
					echo '<option style="font-family: \'Palatino Linotype\'" value="Palatino Linotype">Palatino Linotype</option>\n';
					echo '<option style="font-family: \'Tahoma\'" value="Tahoma">Tahoma</option>\n';
					echo '<option style="font-family: \'Times New Roman\'" value="Times New Roman">Times New Roman</option>\n';
					echo '<option style="font-family: \'Trebuchet MS\'" value="Trebuchet MS">Trebuchet MS</option>\n';
					echo '<option style="font-family: \'Verdana\'" value="Verdana">Verdana</option>\n';
					echo '</select>';
			?>

<div class="noWrap"> &nbsp;&nbsp;</div>
<div class="labeler noWrap"> Font Size: </div>
 <input name="Font_Size_Pref" id="Font_Size_Pref" class="textbox noWrap" type="text" value="<?php echo $_SESSION['Font_Size_Pref']?>"  >


<br> 
<br> 
<br> 
<div class="buttonHolder noWrap">
 <button type="submit" name="submit"> Run Teleprompter (Save First)</button>
 <input id="clickMe" type="button" value="Set As <?php echo $_SESSION['name']; ?>'s Defaults" onclick="doFunction();" />
  <button type="reset" name="reset"> Reset to User Defaults</button>
 </div>



</div>
</form>
<br><br><br>

 <?php include ('footer.php'); ?>