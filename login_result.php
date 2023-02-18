<?php

session_start();
include('backend/conn.php');

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT firstname,lastname,id,password,type,status FROM user WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();


}

if ($stmt->num_rows > 0) {
	$stmt->bind_result($firstname,$lastname,$id,$password,$type,$status);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($_POST['password'], $password)) {

			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
		
		if($status=='Y')
		{
			
			
			if($type=='01')
			$_SESSION['type'] = 'Manager';
			else if($type=='02')
			$_SESSION['type'] = 'Manager';
			else if($type=='03')
			$_SESSION['type'] = 'Office';
			else if($type=='04')
			$_SESSION['type'] = 'Messenger';
			else if($type=='05')
			$_SESSION['type'] = 'Sales';
			else if($type=='99')
			$_SESSION['type'] = 'Admin';

			
			// echo 'Welcome ' . $_SESSION['name'] . '!';
			header( "Location: backend");
		}
		else{
			header( "Location: ..?log=disable");
		}
	} else {
		echo 'Incorrect password!';
		header( "Location: ..?log=password");
	}
} else {
	echo 'Incorrect username!';
	header( "Location: ..?log=username");
}



?>