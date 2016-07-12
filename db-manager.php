<?php
/// This file must be included and the function 'accessAuthenticate()' querried before any HTML is used, even a line feed.
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db_example');

/** MySQL database username */
define('DB_USER', 'db_master');

/** MySQL database password */
define('DB_PASSWORD', 'db_master_pwd');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


/// Basic access authentication
//******** VERY IMPORTANT -- call to this function must be performed before all other functions, especially ones with TRACErs *********
/// ToDo: connect to database
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

/*  Open Database */
// ToDo: Test if DB is already open. (http://alvinalexander.com/blog/post/mysql/how-show-open-database-connections-mysql)
function dbAccessOpen()
{
	$objConn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if ($objConn->connect_error) 
	{
		echo "Unable to select database: " . $objConn->connect_error; 
		return false;
	}
	else
	{
		return $objConn;
	}
}
/* /Open Database */

/*  Close Database */
function dbAccessClose($objConn)
{
	$objConn->close();
}
/* /Close Database */

// ToDo: Safely validate login information



$blnSignedIn=accessAuthenticate(); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DB Document</title>
</head>

<body>
<h2><?=DB_NAME?></h2>
<h3><?=DB_CHARSET?></h3>
<?php
$strTest = 'FOOL a Scouts Canada site near Ayr Ontario' 
. chr(13) .'Camp Location' . "'-- DELETE *"
. chr(13) .'#827559 Township Road 8, Drumbo, ON N0J 1G0' 
. chr(13) .'Township of Blandford-Blenheim, Oxford County' 
. chr(13) .'' 
. chr(13) .'GPS Co-ordinates 43.262218, -80.500216'; 
$objTest = dbAccessOpen();
if($objTest)
{
   echo '<p>'. $objTest->real_escape_string($strTest) .'</p>';
   dbAccessClose($objTest);
}
?>
</body>
</html>
