<?php 
error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	// require a name from user
	if(trim($_POST['contactName']) === '') {
		$nameError =  'Forgot your name!'; 
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	
	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
		

		$phone = trim($_POST['contactPhone']);

		$organization = trim($_POST['organization']);

		$actual_link = trim($_POST['feedbackNews']);

	
	// we need at least some content
	if(trim($_POST['comments']) === '') {
		$commentError = 'You forgot to enter a message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
		
	// upon no failure errors let's email now!
	if(isset($_POST['url']) && $_POST['url'] == '' && (!isset($hasError))) {
		
		$emailTo = 'holloway@umbaugh.com, seever@umbaugh.com';
		$subject = 'Submitted message from the latest news article - '.$actual_link;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \n\nEmail: $email \n\nPhone: $phone \n\nOrganization: $organization \n\nComments: $comments \n\nNews Article: $actual_link";
		$headers .= 'From: Umbaugh Website <no-reply@umbaugh.com>' . "\r\n";
		$headers .= 'Bcc: dannym@quinlanmarketing.com' . "\r\n";
		mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}





//If the UMBAUGH FEEDBACK form is submitted
if(isset($_POST['feedback'])) {
	
	// require a name from user
	$question1 = trim($_POST['feedback1']);

	$question2 = trim($_POST['feedback2']);

	$question3 = trim($_POST['feedback3']);

	$actual_link = trim($_POST['feedbackNews']);

	
	// need valid email
	if(trim($_POST['feedbackEmail']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['feedbackEmail']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$feedbackEmail = trim($_POST['feedbackEmail']);
	}
	
	

	//pulls stuff from inside comments box. validation removed
	$comments = trim($_POST['comments']);
		
	// upon no failure errors let's email now!
	if(isset($_POST['url']) && $_POST['url'] == '' && (!isset($hasError))) {
		
		$emailTo = 'holloway@umbaugh.com, seever@umbaugh.com';
		$subject = 'Submitted message from the latest news article - '.$actual_link;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Is this item worthy of implementation: $question1 \n\nIs this item worth sharing with other associates: $question2 \n\nDid this item present value to you and your business: $question3 \n\nEmail: $feedbackEmail \n\nComments: $comments \n\nNews Article: $actual_link";
		$headers .= 'From: Umbaugh Website <no-reply@umbaugh.com>' . "\r\n";
		$headers .= 'Bcc: dannym@quinlanmarketing.com' . "\r\n";
		//$headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		
		
		mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}



?>