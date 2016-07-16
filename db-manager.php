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
	
	$validated = false;
	
	if( isset( $_SERVER['PHP_AUTH_USER'] ) )
	{
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];		
		$validated = dbUserFound($user, $pass);
	}
	
	if (!$validated) {
		header('WWW-Authenticate: Basic realm="Venue DB"');
		header('HTTP/1.0 401 Unauthorized');
		die( 'You must enter a valid login ID and password to access this resource.' );
		return false;
	} else {
		return true;
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
function dbUserFound( $uname, $upass ) {
	$blnFound = false;
	$objDB = dbAccessOpen();
	if( $objDB ) {
		$strQuery = "SELECT `strUserName`, `strFirstName`, `strLastName`, `blnAdmin`, `blnPermission` FROM `es_users_list` " 
			."WHERE `strUserName`='".$objDB->real_escape_string($uname)."' AND `strPassword`='".$objDB->real_escape_string($upass)."'";
		$objResult = $objDB->query($strQuery);
		$blnFound = ( $objResult->num_rows == 1 ? true : false );
		dbAccessClose( $objDB );
	}
	return $blnFound;
}

/*

TABLE_NAME	COLUMN_NAME		DATA_TYPE	CHARACTER_MAXIMUM_LENGTH	COLLATION_NAME	COLUMN_TYPE
es_users_list	idUser	int	NULL	NULL	int(11)
es_users_list	strUserName	varchar	12	ascii_general_ci	varchar(12)
es_users_list	strFirstName	varchar	30	utf8_general_ci	varchar(30)
es_users_list	strLastName	varchar	30	utf8_general_ci	varchar(30)
es_users_list	strPassword	varchar	15	ascii_general_ci	varchar(15)
es_users_list	blnAdmin	tinyint	NULL	NULL	tinyint(1)
es_users_list	blnPermission	tinyint	NULL	NULL	tinyint(1)
es_users_list	blnCookie	tinyint	NULL	NULL	tinyint(1)
es_users_list	strEmail	varchar	45	ascii_general_ci	varchar(45)
es_users_list	strSMS	varchar	10	ascii_general_ci	varchar(10)

es_venues_list	idVenue	int	NULL	NULL	int(11)
es_venues_list	idUser	int	NULL	NULL	int(11)
es_venues_list	dteEntry	timestamp	NULL	NULL	timestamp
es_venues_list	strLocationName	varchar	50	ascii_general_ci	varchar(50)
es_venues_list	strAddress	mediumtext	16777215	ascii_general_ci	mediumtext
es_venues_list	strCity	varchar	50	ascii_general_ci	varchar(50)
es_venues_list	strProvince	varchar	2	ascii_general_ci	varchar(2)
es_venues_list	strPostalCode	varchar	10	ascii_general_ci	varchar(10)
es_venues_list	strGeolocationStyle	varchar	1	ascii_general_ci	varchar(1)
es_venues_list	strGeolocationPoints	varchar	250	ascii_general_ci	varchar(250)
es_venues_list	strPhoneNumber	varchar	20	ascii_general_ci	varchar(20)
es_venues_list	strContact	varchar	50	ascii_general_ci	varchar(50)
es_venues_list	strEmail	varchar	50	ascii_general_ci	varchar(50)
es_venues_list	strWebSite	varchar	50	ascii_general_ci	varchar(50)
es_venues_list	txtExtraNotes	blob	65535	

*/

// $blnSignedIn=accessAuthenticate(); 
?>
