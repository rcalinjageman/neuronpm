<?php 
# this page deletes the work assigned to a model
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');


if (isset($_REQUEST['user']) ) {
		require_once('../install/pages/config_utils.php'); 
		$conffile = readconf();
		$conffile['USER'] = $_REQUEST['user'];
		$conffile['PASS'] = $_REQUEST['password'];
		writeconf($conffile);
		
		echo "New User and Password Saved.  Please <a href='index.php'>login</a> again.";
		exit();
}
?>
<form name="form1" method="get" action="index.php">
  <p>User:
    <input name="user" type="text" id="user" value="<?php echo USER; ?>">
</p>
  <p>Password: 
    <input type="text" name="password" id="password" value="<?php echo PASS; ?>">
</p>
  <p>
    <input type="submit" name="Submit" value="Change">
  </p>
  <input type="hidden"" name="page" id="page" value="password">
</form>
<p>Here you can change the administrative user name and password used to manage NSweep.</p>
<p>Note that you will have to login again after changing the password. </p>
