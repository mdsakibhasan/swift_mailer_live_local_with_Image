<?php 
date_default_timezone_set("Asia/Dhaka");

require_once(__DIR__.'/vendor/autoload.php');


/*$transport = Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "SSL")
		->setUserName("md.shakhaoathossain@gmail.com")
		->setPassword("S71459284100@1");*/
$transport = Swift_SmtpTransport::newInstance("mail.sakibme.com",25)
						->setUserName("skb@sakibme.com")
						->setPassword("sakib100");

$mailer = Swift_Mailer::newInstance($transport);



if(isset($_POST['sendMessage'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$file = $_FILES['cv'];
	$file_tmpname = $file['tmp_name'];
	$filename = $file['name'];

	$filearray = explode('.', $filename);
	$extension = end($filearray);

	$filename = date('s-i-g-d-m-y-').$filename;


	if( $extension != 'php' ||  $extension != 'js'){
		$upload = move_uploaded_file($file_tmpname, __DIR__.'/assest/cv/'.$filename);
	}



	$message = Swift_Message::newInstance() 
		->setSubject("Some one send a cv or resume")
		->setFrom(array($email => $name)) /*kotha theke jabe*/
		->setTo(array("larapress007@gmail.com" => "larapress"))             /*koi jabe*/
		->setBody($message,'text/html')
		->addPart("this is extra parts")
		->attach(Swift_Attachment::fromPath(__DIR__.'/assest/cv/'.$filename));

	if($upload){
		$attachment = $message->attach(Swift_Attachment::fromPath('something.html'));
	}
	$sendmail = $mailer->send($message);
	if($sendmail){
		echo "your cv has been dorped";
	}
	


	
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>We will send a mail</title>
	<script type="text/javascript" src="assest/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			'selector' : "#message"
		});
	</script>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		<table>
				<tr>
					<td><label for="name">Name:</label></td>
					<td><input type="text" id="name" name="name"></td>
				</tr>
				<tr>
					<td><label for="email">Email:</label></td>
					<td><input type="email" id="email" name="email"></td>
				</tr>
				<tr>
					<td><label for="message">Message:</label></td>
					<td><textarea name="message" id="message" cols="30" rows="10"></textarea></td>
				</tr>
				<tr>
					<td><label for="cv">Attach Your CV:</label></td>
					<td><input type="file" name="cv" id="cv" name="cv"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="SEND MESSAGE" name="sendMessage"></td>
				</tr>
		</table>
	</form>
</body>
</html>