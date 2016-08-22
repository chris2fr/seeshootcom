<?php
// ----INSERT YOUR E_MAIL----- //
define('YOUR_EMAIL','mail@somedomain.tld');
error_reporting(E_ERROR);

header("Content-Type: text/html; charset=utf-8");
// Start the main function
if($_POST["mail"]==1)
{
	sendEmail();
}
else
	validateData();

// Validates data and sending e-mail
function sendEmail()
{
	$output = '';
	$error = 0;
	if(!$_POST['name'])
	{
		$output .= '<p>insert your name</p>';
		$error = 1;
	}
	if(!$_POST['email'])
	{
		$output .= '<p>insert your e-mail</p>';
		$error = 1;
	}
	elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$output .= '<p>wrong e-mail</p>';
		$error = 1;
	}
	
	if(!$_POST['message'])
	{
		$output .= '<p>insert message</p>';
		$error = 1;
	}
	if($error)
	{
		echo '<blockquote class="error margin_1line margin_bottom_1line">'.$output.'</blockquote>';
	}
	else
	{
			$to = YOUR_EMAIL;
			$subject = "Message from the gallery";
			$mbody = "
			Sender:
			".$_POST['name']."
			".$_POST['email']."
			
			Message:
			".$_POST['message']."
			
			";
			
			$headers    = array
			(
				'MIME-Version: 1.0',
				'Content-Type: text/plain; charset="UTF-8";',
				'Content-Transfer-Encoding: 7bit',
				'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
				'From: ' . strip_tags($_POST['email']),
				'Reply-To: ' . strip_tags($_POST['email']),
				'Return-Path: ' . strip_tags($_POST['email']),
				'X-Mailer: PHP v' . phpversion(),
				'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']
			);
			if(mail(YOUR_EMAIL, $subject, $mbody,implode("\n", $headers)))
			{
				echo '<blockquote class="success margin_1line margin_bottom_1line">E-mail was sent.</blockquote>';
			}
			else
			{
				echo '<blockquote class="error margin_1line margin_bottom_1line">Error. Please try again.</blockquote>';				
			}
	}
}

function validateData() {
	
	$required = $_GET["required"];
	$type = $_GET["type"];
	$value = $_GET["value"];

	validateRequired($required, $value, $type);

	switch ($type) {
		case 'number':
			validateNumber($value);
			break;
		case 'alphanum':
			validateAlphanum($value);
			break;
		case 'alpha':
			validateAlpha($value);
			break;
		case 'date':
			validateDate($value);
			break;
		case 'email':
			validateEmail($value);
			break;
		case 'url':
			validateUrl($value);
		case 'all':
			validateAll($value);
			break;
	}
}

// The function to check if a field is required or not
function validateRequired($required, $value, $type) {
	if($required == "required") {

		// Check if we got an empty value
		if($value == "") {
			echo "false";
			exit();
		}
	} else {
		if($value == "") {
			echo "none";
			exit();
		}
	}
}

// Validation of an Email Address
function validateEmail($value) {
	if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of a date
function validateDate($value) {
	if(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $value)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of an URL
function validateUrl($value) {
	if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of characters
function validateAlpha($value) {
	if(preg_match('/^(?=.*[a-z])[a-z -]+$/i', $value)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of characters and numbers
function validateAlphanum($value) {
	if(preg_match('/[^a-z_\-0-9]/i', $value)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of numbers
function validateNumber($value) {
	if(is_numeric($value)) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of numbers
function validateAll($value) {
		echo "true";
}

?>
