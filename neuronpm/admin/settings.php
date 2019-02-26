<?php 
# this page deletes the work assigned to a model
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');


if (isset($_REQUEST['clientpass']) ) {
		require_once('../install/pages/config_utils.php'); 
		$conffile = readconf();
		$conffile['CLIENTPASS'] = $_REQUEST['clientpass'];
		if ($_REQUEST['approvedonly'] == 1) {
			$conffile['APPROVEDONLY'] = $_REQUEST['approvedonly'];
		} else {
			$conffile['APPROVEDONLY'] = 0;
		}
		writeconf($conffile);
		
		echo "<strong>New settings have been saved</strong>";

}
?>
<form name="form1" method="get" action="index.php">
  <p>Client password :
    <input name="clientpass" type="text" id="clientpass" value="<?php echo CLIENTPASS; ?>">
</p>
  <p>
    Allow approved clients only?
    <input name="approvedonly" type="checkbox" id="approvedonly" value="1" <?php if (APPROVEDONLY) {echo "CHECKED"; } ?>>
  </p>
  <p>
    <input type="submit" name="Submit" value="Change">
  </p>
  <input type="hidden"" name="page" id="page" value="settings">
</form>
<p>Here you can change the administrative user name and password used to manage NSweep.</p>
<p>Note that you will have to login again after changing the password. </p>
