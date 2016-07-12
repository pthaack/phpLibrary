<?php
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '956997_example');

/** MySQL database username */
define('DB_USER', '956997_master');

/** MySQL database password */
define('DB_PASSWORD', 'lY9729NEVsbiKIs');

/** MySQL hostname */
define('DB_HOST', 'mariadb-091.wc2.dfw3.stabletransit.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


/// Basic access authentication
//******** VERY IMPORTANT -- call to this function must be performed before all other functions, especially ones with TRACErs *********
/// ToDo: connect to database
function accessAuthenticate() {	 
	$valid_passwords = array ("cinaed" => "password1", "orlaith" => "password2");
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
/*
SELECT `strUserName`, `strFirstName`, `strLastName`, `blnAdmin`, `blnPermission` FROM `es_users_list`
WHERE `strUserName`='cinaed' AND `strPassword`='password1'

http://php.net/manual/en/mysqli.real-escape-string.php
http://stackoverflow.com/questions/3683746/escaping-mysql-wild-cards

SELECT `COLUMN_NAME` FROM `information_schema`.`COLUMNS`
WHERE `TABLE_NAME` = `es_users_list'


SELECT `TABLE_NAME`, `COLUMN_NAME`, `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH`, `COLLATION_NAME`, `COLUMN_TYPE` FROM `COLUMNS`
WHERE `TABLE_NAME` LIKE 'es_%'
TABLE_NAME	COLUMN_NAME	DATA_TYPE	CHARACTER_MAXIMUM_LENGTH	COLLATION_NAME	COLUMN_TYPE	
 Current selection does not contain a unique column. Grid edit, checkbox, Edit, Copy and Delete features are not available.
 Showing rows 0 - 24 (25 total, Query took 0.0169 seconds.)
SELECT `TABLE_NAME`, `COLUMN_NAME`, `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH`, `COLLATION_NAME`, `COLUMN_TYPE` FROM `COLUMNS` WHERE `TABLE_NAME` LIKE 'es_%'

TABLE_NAME
COLUMN_NAME
DATA_TYPE
CHARACTER_MAXIMUM_LENGTH
COLLATION_NAME
COLUMN_TYPE
es_users_list
idUser
int
NULL
NULL
int(11)
es_users_list
strUserName
varchar
12
ascii_general_ci
varchar(12)
es_users_list
strFirstName
varchar
30
utf8_general_ci
varchar(30)
es_users_list
strLastName
varchar
30
utf8_general_ci
varchar(30)
es_users_list
strPassword
varchar
15
ascii_general_ci
varchar(15)
es_users_list
blnAdmin
tinyint
NULL
NULL
tinyint(1)
es_users_list
blnPermission
tinyint
NULL
NULL
tinyint(1)
es_users_list
blnCookie
tinyint
NULL
NULL
tinyint(1)
es_users_list
strEmail
varchar
45
ascii_general_ci
varchar(45)
es_users_list
strSMS
varchar
10
ascii_general_ci
varchar(10)
es_venues_list
idVenue
int
NULL
NULL
int(11)
es_venues_list
idUser
int
NULL
NULL
int(11)
es_venues_list
dteEntry
timestamp
NULL
NULL
timestamp
es_venues_list
strLocationName
varchar
50
ascii_general_ci
varchar(50)
es_venues_list
strAddress
mediumtext
16777215
ascii_general_ci
mediumtext
es_venues_list
strCity
varchar
50
ascii_general_ci
varchar(50)
es_venues_list
strProvince
varchar
2
ascii_general_ci
varchar(2)
es_venues_list
strPostalCode
varchar
10
ascii_general_ci
varchar(10)
es_venues_list
strGeolocationStyle
varchar
1
ascii_general_ci
varchar(1)
es_venues_list
strGeolocationPoints
varchar
250
ascii_general_ci
varchar(250)
es_venues_list
strPhoneNumber
varchar
20
ascii_general_ci
varchar(20)
es_venues_list
strContact
varchar
50
ascii_general_ci
varchar(50)
es_venues_list
strEmail
varchar
50
ascii_general_ci
varchar(50)
es_venues_list
strWebSite
varchar
50
ascii_general_ci
varchar(50)
es_venues_list
txtExtraNotes
blob
65535
*/


// ToDo: Post venue information
/*
Array
(
    [locationName] => Camp Impessa
    [address] => 827559 Township Rd. 8,
    [city] => Ayr
    [province] => ON
    [postalCode] => N3L 3E2
    [geolocationStyle] => point
    [geolatitude] => 43.262218
    [geolongitude] => -80.500216
    [mapLock] => maplock
    [phoneNumber] => 519-432-2928
    [contact] => 
    [email] => swocamps@scouts.ca
    [webSite] => camp-impeesa.ca
    [extraNotes] => FOOL a Scouts Canada site near Ayr Ontario
Camp Location
#827559 Township Road 8, Drumbo, ON N0J 1G0
Township of Blandford-Blenheim, Oxford County

GPS Co-ordinates 43.262218, -80.500216
    [submit] => Submit
)

SELECT `COLUMN_NAME` FROM `information_schema`.`COLUMNS`
WHERE `TABLE_NAME` = 'es_venues_list'
COLUMN_NAME
idVenue
idUser
dteEntry
strLocationName
strAddress
strCity
strProvince
strPostalCode
strGeolocationStyle
strGeolocationPoints
strPhoneNumber
strContact
strEmail
strWebSite
txtExtraNotes
*/

// ToDo: Retrieve nearby venue information



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
