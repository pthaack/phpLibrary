<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- add this URI to the "action" parameter in a <FORM> tag. It returns the raw data posted to that form. -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View post entries</title>
</head>

<body>
<p><?php echo '<pre>'; print_r($_POST); echo '</pre>'; ?></p>  
</body>
</html>
