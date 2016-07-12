<?php
/// Basic access authentication, header creator
/// This file must be included and the function 'accessAuthenticate()' querried before any HTML is used, even a line feed.
function accessAuthenticate() {	 
	$valid_passwords = array ("user1" => "password1", "user2" => "password2");
	$valid_users = array_keys($valid_passwords);
	
	$validated = false;
	
	if( isset( $_SERVER['PHP_AUTH_USER'] ) )
	{
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];		
		$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
	}
	
	if (!$validated) {
		header('WWW-Authenticate: Basic realm="Venue DB"');
		header('HTTP/1.0 401 Unauthorized');
		die( 'You must enter a valid login ID and password to access this resource.' );
		return false;
	} else {
		return true;
//		echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
//		echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
	}
}
?>
