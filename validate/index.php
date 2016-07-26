<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 26.07.2016
 * Time: 08:28
 */

require_once ('index_top.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Degradable AJAX Form Validation with PHP and MySQL</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="validate.css" rel="stylesheet" type="text/css">
</head>
<body onload="setFocus();">
<script src="json2.js"></script>
<script src="xhr.js"></script>
<script src="validate.js"></script>

	<pre>
	<?php print_r($_SESSION); ?>
	</pre>

	<fieldset>
		<legend>
			New User Registration Form
		</legend>
		<br>
		<form name="frmRegistration" method="post" action="validate.php">
			<input type="hidden" name="validationType" value="php">

			<!-- Username -->
			<label for="txtUsername">Desired username:</label>
			<input id="txtUsername" name="txtUsername" type="text"
				onblur="validate(this.value, this.id)"
				value="<?php echo $_SESSION['values']['txtUsername']; ?>">
			<span id="txtUsernameFailed"
				  class="<?php echo $_SESSION['errors']['txtUsername']; ?>">
				This username is in use, or empty username field.
			</span>
			<br>

			<!-- Name -->
			<label for="txtName">Your name:</label>
			<input id="txtName" name="txtName" type="text"
				onblur="validate(this.value, this.id)"
				value="<?php echo $_SESSION['values']['txtName']; ?>">
			<span id="txtNameFailed"
				class="<?php echo $_SESSION['errors']['txtName']; ?>">
				Please enter your name.
			</span>
			<br>

			<!-- Gender -->
			<label for="selGender">Gender:</label>
			<select id="selGender" name="selGender"
				   onblur="validate(this.value, this.id)">
			   <?php buildOptions($genderOptions, $_SESSION['values']['selGender']); ?>
			</select>
			<span id="selGenderFailed"
				  class="<?php echo $_SESSION['errors']['selGender']; ?>">
				Please select your gender.
			</span>
			<br>

			<!-- Birthday -->
			<label for="selBthMonth">Birthday:</label>

			<!-- Month -->
			<select id="selBthMonth" name="selBthMonth"
				   onblur="validate(this.value, this.id)">
			   <?php buildOptions($monthOptions, $_SESSION['values']['selBthMonth']); ?>
			</select>
			&nbsp;-&nbsp;

			<!-- Day -->
			<input type="text" name="txtBthDay" id="txtBthDay"
				maxlength="2" size="2"
				onblur="validate(this.value, this.id)"
				value="<?php echo $_SESSION['values']['txtBthDay']; ?>">
			&nbsp;-&nbsp;

			<!-- Year -->
			<input type="text" name="txtBthYear" id="txtBthYear"
				maxlength="4" size="2"
				onblur="validate(document.getElementById('selBthMonth')
					.options[document.getElementById('selBthMonth')
					.selectedIndex].value +
					'#' + document.getElementById('txtBthDay').value +
					'#' + this.value, this.id)"
				value="<?php echo $_SESSION['values']['txtBthYear']; ?>">

			<!-- Month, Day, Year validation -->
			<span id="selBthMonthFailed"
				class="<?php echo $_SESSION['errors']['selBthMonth']; ?>">
				Please select your birth month.
			</span>
			<span id="selBthDayFailed"
				class="<?php echo $_SESSION['errors']['txtBthDay']; ?>">
				Please select your birth day.
			</span>
			<span id="txtBthYearFailed"
				class="<?php echo $_SESSION['errors']['txtBthYear']; ?>">
				Please enter a valid date.
			</span>
			<br>

			<!-- Email -->
			<label for="txtEmail">E-mail:</label>
			<input id="txtEmail" name="txtEmail" type="text"
				   onblur="validate(this.value, this.id)"
				   value="<?php echo $_SESSION['values']['txtEmail']; ?>">
			<span id="txtEmailFailed"
				  class="<?php echo $_SESSION['errors']['txtEmail']; ?>">
				Invalid e-mail address.
			</span>
			<br>

			<!-- Phone number -->
			<label for="txtPhone">Phone Number:</label>
			<input id="txtPhone" name="txtPhone" type="text"
				   onblur="validate(this.value, this.id)"
				   value="<?php echo $_SESSION['values']['txtPhone']; ?>">
			<span id="txtPhoneFailed"
				  class="<?php echo $_SESSION['errors']['txtPhone']; ?>">
				Please insert a valid US phone number (xxx-xxx-xxxx).
			</span>
			<br>

			<!-- Read terms checkbox -->
			<input id="chkReadTerms" name="chkReadTerms"
				   type="checkbox" class="left"
				   onblur="validate(this.value, this.id)"
			   <?php if($_SESSION['values']['chkReadTerms'] ==
			   	'on') echo 'checked="checked"'; ?>>
			I've read the Terms of Use
			<span id="chkReadTermsFailed"
				  class="<?php echo $_SESSION['errors']['chkReadTerms']; ?>">
				Please make sure you read the Terms of Use.
			</span>
			<br>

			<!-- End of form -->
			<hr>
			<span class="txtSmall">Note: All fields are required.</span>
			<br><br>
			<input type="submit" name="submitbutton" value="Register"
				class="left button">
		</form>
	</fieldset>
</body>
</html>
