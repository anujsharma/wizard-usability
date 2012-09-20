<?php
//Retrieve form data.
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
$firstName = ($_GET['email_us_first_name']) ? $_GET['email_us_first_name'] : $_POST['email_us_first_name'];
$lastName = ($_GET['email_us_last_name']) ? $_GET['email_us_last_name'] : $_POST['email_us_last_name'];
$email = ($_GET['email_us_email']) ? $_GET['email_us_email'] : $_POST['email_us_email'];
$company = ($_GET['email_us_company']) ? $_GET['email_us_company'] : $_POST['email_us_company'];
$subject = ($_GET['email_us_subject']) ? $_GET['email_us_subject'] : $_POST['email_us_subject'];
$message = ($_GET['email_us_message']) ? $_GET['email_us_message'] : $_POST['email_us_message'];

$appType = ($_GET['appTypeValue']) ? $_GET['appTypeValue'] : $_POST['appTypeValue'];
$appIndustryValue = ($_GET['appIndustryValue']) ? $_GET['appIndustryValue'] : $_POST['appIndustryValue'];
$testingDeliverablesValue= ($_GET['testingDeliverablesValue']) ? $_GET['testingDeliverablesValue'] : $_POST['testingDeliverablesValue'];
$testingDurationValue = ($_GET['testingDurationValue']) ? $_GET['testingDurationValue'] : $_POST['testingDurationValue'];
$priceEstimate = ($_GET['priceEstimate']) ? $_GET['priceEstimate'] : $_POST['priceEstimate'];


if ($_POST) $post=1;
 
if (!$firstName) $errors[count($errors)] = 'Please enter your first name.';
if (!$lastName) $errors[count($errors)] = 'Please enter your last name.';
if (!$email) $errors[count($errors)] = 'Please enter your email.';

 
//if the errors array is empty, send the mail
if (!$errors) {
	    
    $to = 'uTest Wizard <Wizard@uTest.com>';
	
    $from = $firstName.' ' .$lastName . ' <' . $email . '>';
     
    //subject and the html message
    $subject = 'Email From ' . $firstName.' ' .$lastName;
    $message = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head></head>
    <body>
	<h1>UX Test Planning Wizard</h1>
	<h2>Email Us</h2>
    <table>
        <tr><td>First Name</td><td>' . $firstName . '</td></tr>
		<tr><td>Last Name</td><td>' . $lastName . '</td></tr>
        <tr><td>Email</td><td>' . $email . '</td></tr>
        <tr><td>Company</td><td>' . $company . '</td></tr>
		<tr><td>Subject</td><td>' . $subject . '</td></tr>		
        <tr><td>Message</td><td>' . nl2br($message) . '</td></tr>
		
		
		<tr><td>App Type</td><td>' . $appType . '</td></tr>	
		<tr><td>App Industry</td><td>' . $appIndustryValue . '</td></tr>
		<tr><td>Testing Deliverables</td><td>' . $testingDeliverablesValue . '</td></tr>		
		<tr><td>Number of Projects</td><td>' . $testingDurationValue . '</td></tr>
		<tr><td>Price Estimate</td><td>' . $priceEstimate . '</td></tr>
    </table>
    </table>
    </body>
    </html>';
 
    //send the mail
    $result = sendmail($to, $subject, $message, $from);
     
    //if POST was used, display the message straight away
    if ($_POST) {
        if ($result)
		{
			$pageURL = "/wizard-usability";					
			header('Location: '.$pageURL);
		}		
        else {
			echo 'Sorry, unexpected error. Please try again later';
		}
         
    //else if GET was used, return the boolean value so that
    //ajax script can react accordingly
    //1 means success, 0 means failed
    } 
	else {
        echo $result;  
    }

} else {
    //display the errors message
    for ($i=0; $i<count($errors); $i++) echo $errors[$i] . '<br/>';
    echo '<a href="main.php">Back</a>';
    exit;
}
 
 
//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
     
    $result = mail($to,$subject,$message,$headers);
     
    if ($result) return 1;
    else return 0;
}
?>