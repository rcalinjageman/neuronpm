<?php
# this is the dbconfig page for NSweep
#  i actually wrote this, and it shows
#
# Bob Calin-Jageman
	if (!defined('BASE')) exit('');
	
	
	if(isset($_REQUEST['config'])) {
		if (!isset($_REQUEST['DB_HOST']) || $_REQUEST['DB_HOST'] == "") {
			echo "DB Host required; Please use back and fill in form completely.";
			break;
		} 
		
		if (!isset($_REQUEST['DB_PORT']) || $_REQUEST['DB_PORT'] == "") {
			echo "DB Port required; Please use back and fill in form completely.";
			break;
		}
		
		if (!isset($_REQUEST['DB_NAME']) || $_REQUEST['DB_NAME'] == "") {
			exit("DB Name required; Please use back and fill in form completely.");
		}
		
		if (!isset($_REQUEST['DB_USER']) || $_REQUEST['DB_USER'] == "") {
			exit("DB USER required; Please use back and fill in form completely.");
		}
		
		if (!isset($_REQUEST['DB_PASS']) || $_REQUEST['DB_PASS'] == "") {
			exit("DB Pass required; Please use back and fill in form completely.");
		}
		
		require_once('config_utils.php'); 
		
		$conffile = readconf();
		
		$conffile['DB_HOST'] = $_REQUEST['DB_HOST'];
		$conffile['DB_PORT'] = $_REQUEST['DB_PORT'];
		$conffile['DB_USER'] = $_REQUEST['DB_USER'];
		$conffile['DB_NAME'] = $_REQUEST['DB_NAME'];
		$conffile['DB_PASS'] = $_REQUEST['DB_PASS'];
		
		writeconf($conffile);
		
		$reload = "Location: index.php?page=dbconfig&saved=true";
		header($reload);
		exit("saved");
	}
	
	if (isset($_REQUEST['saved'])) {
		echo "<b>Settings have been saved and new values are listed below.<br>";
		echo "If you are happy with these values, go to the next step.</b><br><br>";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NSweep Install</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h3>DBConfig</h3>
<form action="index.php" method="get" name="CONFIG" id="CONFIG">
  <p>Tell NSweep how to connect to your MySQL server and the database you created for it: </p>
  <p>MySQL Hostname: 
    <input name="DB_HOST" type="text" id="DB_HOST" value = "<?php echo DB_HOST;?>"> 
  <br>
 (localhost if MySQL is on the same machine as your webserver) </p>
  <p>MySQL HostPort:
    <input name="DB_PORT" type="text" id="DB_PORT" value = "<?php echo DB_PORT;?>"> 
    <br>(default is usually correct) </p>
  <p>DbName: 
    <input name="DB_NAME" type="text" id="DB_NAME" value = "<?php echo DB_NAME; ?>"> 
    <br>(the name of the MySQL db you created for use with NSweep) </p>
  <p>DbUser: 
    <input name="DB_USER" type="text" id="DB_USER" value = "<?php echo DB_USER; ?>">
 <br>(the username of a MySQL user with general priveleges)</p>
  <p>DbPass: 
    <input name="DB_PASS" type="text" id="DB_PASS" value = "<?php echo DB_PASS; ?>"> 
    <br>(password for this username)
</p>
  <p>
    <input name="page" type="hidden" id="page" value="dbconfig">
  </p>
  <p>
    <input name="config" type="submit" id="config" value="Save">
</p>
</form>
<p>First save the settings. Once you've received confirmation that the settings have been saved, move on to the next step. </p>
</body>
</html>
