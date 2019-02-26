<?php
# this file is an initialization for any client page
# 
# this file should be included on each client page
# Bob Calin-Jageman

#validation
$timeout = "<nsweep>pause=1200<nsweep><br>";

if (!isset($_REQUEST['host'])) {
	exit($timeout."<nsweep>nowork=no host identified</nsweep>");
}

if (!isset($_REQUEST['password'])) {
	exit($timeout."<nsweep>no password</nsweep>");
}

require_once("conf/config.php");

if ($_REQUEST['password'] != CLIENTPASS) { exit($timeout."<nsweep>nowork=wrong password</nsweep>"); }

#check ip
	require_once('Connections/conn_nsweep.php'); 
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_clients = sprintf("SELECT * FROM nsweep_clients WHERE ip = '%s' AND host='%s'", $_SERVER['REMOTE_ADDR'], $_REQUEST['host']);
	$rs_clients = mysql_query($query_rs_clients, $conn_nsweep) or die($rs_clients);
	$row_rs_clients = mysql_fetch_assoc($rs_clients);
	$newclient = 0;
	$approved = 0;
	
	if (mysql_num_rows($rs_clients) == 0) {
		$newclient = 1;
	} else {
		$approved = $row_rs_clients['approved'];
	}
	mysql_free_result($rs_clients);
	
	if ($approved == -1) { exit($timeout."<nsweep>nowork=BANNED</nsweep>"); }
	
	if (APPROVEDONLY) {
	  if (($newclient) || ($approved == 0)) { exit($timeout."<nsweep>nowork=Wait for approval</nsweep>"); }
	} 

#now that the client has been fully validated, do some setup
	
# copied from eponentcms.org, used to determine base path of the installation
function __realpath($path) {
	$path = str_replace('\\','/',realpath($path));
	if ($path{1} == ':') {
		// We can't just check for C:/, because windows users may have the IIS webroot on X: or F:, etc.
		$path = substr($path,2);
	}
	return $path;
}

if (!defined('BASE')) {
	/*
	 * BASE Constant
	 *
	 * The BASE constant is the absolute path on the server filesystem, from the root (/ or C:\)
	 * to the Exponent directory.
	 */
	define('BASE',__realpath(dirname(__FILE__)).'/');
}
echo "<nsweep>validated=true</nsweep>";
?>

