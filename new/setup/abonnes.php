<?php
require('database.php');

if (isset($_POST['subscribe'])) {
	$email = htmlspecialchars($_POST['email']);

	if (!empty($_POST['email'])) {
		
		$insert = $db->prepare("INSERT INTO contact(email) VALUES(?)");

		$insert->execute(array($email));

		$error = 'Félicitation '. $email . '. Vous êtes un nouveau abonné de NYONNUI.';

	}else{
		$error = 'Veuillez entrer votre adresse E-mail pour vous abonner';

	
	}
}


?>
