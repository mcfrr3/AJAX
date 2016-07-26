<?php

/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 26.07.2016
 * Time: 09:30
 */

// load error handler and database configuration
require_once ('error_handler.php');
require_once ('../config.php');

/**
 * Class validate
 * supports AJAX and PHP web form validation
 */
class Validate
{
	// stored database connection
	private $mMysqli;

	// constructor opens database connection
	function __construct()
	{
		$this->mMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	}

	// destructor closes database connection
	function __destruct()
	{
		$this->mMysqli->close();
	}

	// supports AJAX validation, verifies a single value
	public function ValidateAJAX($inputValue, $fieldID){
		// check which field is being validated and perform
		// validation
		switch ($fieldID){
			// check if the username is valid
			case 'txtUsername':
				return $this->validateUserName($inputValue);
			break;

			// check if the name is valid
			case 'txtName':
				return $this->validateName($inputValue);
			break;

			// check if a gender was selected
			case 'selGender':
				return $this->validateGender($inputValue);
			break;

			// check if birth month is valid
			case 'selBthMonth':
				return $this->validateBirthMonth($inputValue);
			break;

			// check if birth day is valid
			case 'txtBthDay':
				return $this->validateBirthDay($inputValue);
			break;

			// check if birth year is valid
			case 'txtBthYear':
				return $this->validateBirthYear($inputValue);
			break;

			// check if email is valid
			case 'txtEmail':
				return $this->validateEmail($inputValue);
			break;

			// check if phone is valid
			case 'txtPhone':
				return $this->validatePhone($inputValue);
			break;

			// check if "I have read the terms" checkbox has been
			// checked
			case 'chkReadTerms':
				return $this->validateReadTerms($inputValue);
			break;
		}
	}

	// validates all form fields on form submit
	public function ValidatePHP(){
		// error flag, becomes 1 when errors are found.
		$errorsExist = 0;

		// clears the errors session flag
		if(isset($_SESSION['errors'])){
			unset($_SESSION['errors']);
		}

		// by default all fields are considered valid
		$_SESSION['errors']['txtUsername'] = 'hidden';
		$_SESSION['errors']['txtName'] = 'hidden';
		$_SESSION['errors']['selGender'] = 'hidden';
		$_SESSION['errors']['selBthMonth'] = 'hidden';
		$_SESSION['errors']['txtBthDay'] = 'hidden';
		$_SESSION['errors']['txtBthYear'] = 'hidden';
		$_SESSION['errors']['txtEmail'] = 'hidden';
		$_SESSION['errors']['txtPhone'] = 'hidden';
		$_SESSION['errors']['chkReadTerms'] = 'hidden';

		// validate username
		if(!$this->validateUserName($_POST['txtUsername'])){
			$_SESSION['errors']['txtUsername'] = 'error';
			$errorsExist = 1;
		}

		// validate name
		if(!$this->validateName($_POST['txtName'])){
			$_SESSION['errors']['txtName'] = 'error';
			$errorsExist = 1;
		}

		// validate gender
		if(!$this->validateGender($_POST['selGender'])){
			$_SESSION['errors']['selGender'] = 'error';
			$errorsExist = 1;
		}

		// validate birth month
		if(!$this->validateBirthMonth($_POST['selBthMonth'])){
			$_SESSION['errors']['selBthMonth'] = 'error';
			$errorsExist = 1;
		}

		// validate birth day
		if(!$this->validateBirthDay($_POST['txtBthDay'])){
			$_SESSION['errors']['txtBthDay'] = 'error';
			$errorsExist = 1;
		}

		// validate birth year and date
		if(!$this->validateBirthYear(
			$_POST['selBthMonth'] . '#' .
			$_POST['txtBthDay'] . '#' .
			$_POST['txtBthYear'])){

			$_SESSION['errors']['txtBthYear'] = 'error';
			$errorsExist = 1;
		}

		// validate email
		if(!$this->validateEmail($_POST['txtEmail'])){
			$_SESSION['errors']['txtEmail'] = 'error';
			$errorsExist = 1;
		}

		// validate phone
		if(!$this->validatePhone($_POST['txtPhone'])){
			$_SESSION['errors']['txtPhone'] = 'error';
			$errorsExist = 1;
		}

		// validate read terms
		if(!isset($_POST['chkReadTerms'])
			|| !$this->validateReadTerms($_POST['chkReadTerms'])){

			$_SESSION['errors']['chkReadTerms'] = 'error';
			$_SESSION['values']['chkReadTerms'] = '';
			$errorsExist = 1;
		}

		// if no errors are found, point to a successful validation
		// page
		if($errorsExist == 0){
			return 'allok.php';
		}else{
			// if errors are found, save current user input
			foreach ($_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
			}
			return 'index.php';
		}
	}

	// validate user name (must be empty, and must not be already
	// registered)
	private function validateUserName($value){
		// trim and escape input value
		$value = $this->mMysqli->real_escape_string(trim($value));

		// empty user name is not valid
		if($value == null){
			return 0; // not valid
		}

		// check if the username ixists in the database
		$query = $this->mMysqli->query('
			SELECT user_name FROM users
			WHERE user_name = \''. $value .'\'');

		if($this->mMysqli->affected_rows > 0){
			return '0'; // not valid
		}else{
			return '1'; // valid
		}
	}

	// validate name
	private function validateName($value){
		// trim and escape input value
		$value = trim($value);

		// empty user name is not valid
		if($value){
			return 1; // valid
		}else{
			return 0; // not valid
		}
	}

	// validate gender
	private function validateGender($value){
		// user must have a gender
		return ($value == '0') ? 0 : 1;
	}

	// validate birth month
	private function validateBirthMonth($value){
		// month must be non-null, and between 1 and 12
		return ($value == '' || $value > 12 || $value < 1) ? 0 : 1;
	}

	// validate birth day
	private function validateBirthDay($value){
		// day must be non-null, and between 1 and 31
		return ($value == '' || $value > 31 || $value < 1) ? 0 : 1;
	}

	// validate birth year and the whole date
	private function validateBirthYear($value){
		// valid birth year is between 1900 and 2000
		// get whole date (mm#dd#yyyy)
		$date = explode('#', $value);

		// date can't be valid if there is no day, month, or year
		if(!$date[0]) return 0;
		if(!$date[1] || !is_numeric($date[1])) return 0;
		if(!$date[2] || !is_numeric($date[2])) return 0;

		// check the date
		return (checkdate($date[0], $date[1], $date[2])) ? 1 : 0;
	}

	// validate email
	private function validateEmail($value){
		// valid email formats: *@*.*, *@*.*.*, *.*@*.*, *.*@*.*.*
		return (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@
			[a-z0-9-]+(\.[a-z0-9-]+)*
			(\.[a-z]{2,3})$/i', $value)) ? 0 : 1;
	}

	// validate phone
	private function validatePhone($value){
		// valid phone format: ###-###-####
		return (!preg_match('/^\d{3}-*\d{3}-*\d{4}$/', $value)) ? 0 : 1;
	}

	// check the user has read the terms of use
	private function validateReadTerms($value){
		// valid value is 'true'
		return ($value == 'true' || $value == 'on') ? 1 : 0;
	}
}

?>