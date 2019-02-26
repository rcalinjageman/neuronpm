<?php
# this is the checkin for nsweep clients
# 
# Bob Calin-Jageman

#validation

function timeout($duration) {
	return "<nsweep>pause=".$duration."</nsweep><br>";
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function saverecord($newvalues, $oldvalues, $table, $keycolumn, $conn) {
		$updateSQL = "UPDATE `".$table."` SET ";
		$setline = "";
		reset($newvalues);
		while($key = key($newvalues)) {
			if ($newvalues[$key] != $oldvalues[$key]) {
				if (strlen($setline) != 0) { $setline .= ", "; }
				$setline.= sprintf("`%s` = %s", $key, GetSQLValueString($newvalues[$key], "text"));
			}
			next($newvalues);
		}
		if (strlen($setline) > 0) {
			$updateSQL = $updateSQL.$setline." WHERE `".$keycolumn."` = ".GetSQLValueString($oldvalues[$keycolumn], "text");
			$rs_clients = mysql_query($updateSQL, $conn) or die(mysql_error());
		}
}

#validation
#	validation part1  - is everything sent?
if (!isset($_REQUEST['host'])) {
	exit(timeout("1200")."<nsweep>nowork=no host identified</nsweep>");
}

if (!isset($_REQUEST['password'])) {
	exit(timeout("1200")."<nsweep>nowork=no password</nsweep>");
}

if (!isset($_REQUEST['clientversion'])) {
	exit(timeout("1200")."<nsweep>nowork=no client version</nsweep>");
}

require_once("../conf/config.php");

#	validation part2 - is ip ok?
echo "ok";
	require_once('../Connections/conn_nsweep.php'); 
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_clients = sprintf("SELECT * FROM nsweep_clients WHERE ip = '%s' AND host='%s'", $_SERVER['REMOTE_ADDR'], $_REQUEST['host']);
	$rs_clients = mysql_query($query_rs_clients, $conn_nsweep) or die("ok");
	$row_rs_clients = mysql_fetch_assoc($rs_clients);
	$newclient = 0;
	$approved = 0;
	
	if (mysql_num_rows($rs_clients) == 0) {
		#new client
		$newclient = 1;
		$approved = 0;
		
		$insertSQL = sprintf("INSERT INTO nsweep_clients (ip, host, cameon, timeon, lastcomm) VALUES (%s, %s, 0, 0, %s)",
                       GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"),
                       GetSQLValueString($_REQUEST['host'], "text"),
					   GetSQLValueString(date("Y/m/d H:i:s"), "date")
					   );
		$rs_clients = mysql_query($insertSQL, $conn_nsweep) or die(mysql_error());
		$rs_clients = mysql_query($query_rs_clients, $conn_nsweep) or die($rs_clients);
		$row_rs_clients = mysql_fetch_assoc($rs_clients);
		if (APPROVEDONLY) { exit(timeout("1200")."<nsweep>nowork=new client await approval</nsweep>"); }
	} else {
		$approved = $row_rs_clients['approved'];
	}
	
	$newvalues = array();
	$newvalues['lastmess'] = $_SERVER['QUERY_STRING'];
	$newvalues['lastcomm'] = date("Y/m/d H:i:s");
	#$newvalues['lastcomm'] = date("Y/m/d H:i:s");
		
	if ($approved == -1) {
		$newvalues['lastreply'] = "banned";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);
		mysql_free_result($rs_clients);
		exit(timeout("12000")."<nsweep>nowork=BANNED</nsweep>"); 
	}
	
	if ((APPROVEDONLY) && $approved == 0) {
		$newvalues['lastreply'] = "waiting for approval";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);
		mysql_free_result($rs_clients);
		exit(timeout("1200")."<nsweep>nowork=Keep waiting for approval</nsweep>");
	} 

#	validation part 3 - made it this far, check pass and send old pass if it exists
	if ($_REQUEST['password'] != CLIENTPASS) {
		if ((defined(OLDCLIENTPASS)) && ($_REQUEST['password'] == OLDCLIENTPASS)) {
			$newvalues['lastreply'] = "resetting password";
			saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);
			mysql_free_result($rs_clients);
			exit(timeout("1200")."<nsweep>password=".CLIENTPASS."</nsweep><nsweep>command=setpass</nsweep>");
		} else {
		exit(timeout("12000")."<nsweep>nowork=wrong password</nsweep>");
		}
	}
	
# Client is ok; What should this client do?  
	echo "<nsweep>clientid=".$_SERVER['REMOTE_ADDR']."-".$_REQUEST['host']."</nsweep>";

	#see if there is an active model and if the client has it
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_models = "SELECT * FROM nsweep_models WHERE active = 1";
	$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
	$row_rs_active = mysql_fetch_assoc($rs_active);
	
	if (mysql_num_rows($rs_active) != 1) { 
		$newvalues['lastreply'] = "nothing published";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
		mysql_free_result($rs_active);
		mysql_free_result($rs_clients);
		exit(timeout("1200")."<nsweep>nowork=no model published</nsweep>");
	}
	
	if ((!isset($_REQUEST['model'])) || (!isset($_REQUEST['modelversion']))) {
		$newvalues['lastreply'] = "setmodel";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
		mysql_free_result($rs_active);
		mysql_free_result($rs_clients);
		exit(timeout("60")."<nsweep>command=setmodel</nsweep><br><nsweep>model=".$row_rs_active['model']."</nsweep>");
	}
	
	if ($_REQUEST['model'] != $row_rs_active['model']) {
		$newvalues['lastreply'] = "setmodel";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
		mysql_free_result($rs_active);	
		mysql_free_result($rs_clients);
		exit(timeout("60")."<nsweep>command=setmodel</nsweep><br><nsweep>model=".$row_rs_active['model']."</nsweep>");
	}
	
	if ($_REQUEST['modelversion'] != $row_rs_active['version']) {
		$newvalues['lastreply'] = "setmodel";
		saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
		mysql_free_result($rs_active);
		mysql_free_result($rs_clients);
		exit(timeout("60")."<nsweep>command=setmodel</nsweep><br><nsweep>model=".$row_rs_active['model']."</nsweep>");
	}
	
	#client has the correct model; now see if it knows what to do
	$workvalues = array();
	
	if (!isset($_REQUEST['workstart'])) {
		#doesn't have a work assignment - give it one
		mysql_select_db($database_conn_nsweep, $conn_nsweep);
		$query_rs_work = "SELECT * FROM `nsweep_work` WHERE (`model` = '".$row_rs_active['model']."') AND (`assignment` > -1) AND (`clientid` = ".$row_rs_clients['clientid'].") ORDER BY `nsweep_work`.`workstart` LIMIT 0,1";
		$rs_work = mysql_query($query_rs_work, $conn_nsweep) or die("");
		$row_rs_work = mysql_fetch_assoc($rs_work);
		if (mysql_num_rows($rs_work) == 0) {
			$query_rs_work = "SELECT * FROM `nsweep_work` WHERE (`model` = '".$row_rs_active['model']."') AND (`assignment` = 0) ORDER BY `nsweep_work`.`workstart` LIMIT 0,1";
			$rs_work = mysql_query($query_rs_work, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
			$row_rs_work = mysql_fetch_assoc($rs_work);
		}
		
		if(mysql_num_rows($rs_work) == 0) {
			# no work to give, the published model is all done
			$newvalues['lastreply'] = "No work";
			saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
			mysql_free_result($rs_active);
			mysql_free_result($rs_clients);
			mysql_free_result($rs_work);
			exit(timeout("1200")."<nsweep>nowork=No work</nsweep><br>");
		}
		
		$newvalues['lastreply'] = "setwork and checked in";
		$newvalues['lastcomm'] = date("Y/m/d H:i:s");
    	$newvalues['status'] = 1;
			if ($row_rs_clients['lastreply'] != "uploaded") {
  				$newvalues['cameon'] = $row_rs_clients['cameon'] + 1;
			}
			
		if ($row_rs_clients['started'] ==0) { $newvalues['started'] = date("Y/m/d H:i:s"); }
			 
		$newvalues['cblock'] = $_REQUEST['workstart'];
		$newvalues['model'] = $_REQUEST['model'];
		$newvalues['modelversion'] = $_REQUEST['modelversion'];
		$newvalues['clientversion'] = $_REQUEST['clientversion'];
	
		$workvalues['timestarted'] = date("Y/m/d H:i:00");
		$workvalues['clientid'] = $row_rs_clients['clientid'];
		$workvalues['assignment'] = 1; 
    	$workvalues['checkins'] = $row_rs_work['checkins'] + 1;
		$workvalues['pdone'] = 0; 
				
		echo "<nsweep>workstart=".$row_rs_work['workstart']."</nsweep><br>";
		echo "<nsweep>blocksize=".$row_rs_work['blocksize']."</nsweep><br>";
		echo "<nsweep>command=setwork</nsweep>";
	} else {
		#the client has work, check to see if it should go ahead or drop the work
		mysql_select_db($database_conn_nsweep, $conn_nsweep);
		$query_rs_work = "SELECT * FROM `nsweep_work` WHERE (`model` = '".$row_rs_active['model']."') AND (`assignment` > -1) AND(`clientid` = '".$row_rs_clients['clientid']."') AND (`workstart` = '".$_REQUEST['workstart']."') ORDER BY `nsweep_work`.`workstart`";
		$rs_work = mysql_query($query_rs_work, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
		$row_rs_work = mysql_fetch_assoc($rs_work);
		
		if (mysql_num_rows($rs_work) == 0) { 
		
			$newvalues['lastreply'] = "dropwork - block deleted";
			$newvalues['status'] = 0;
			$newvalues['cblock'] = -1;
			saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
			mysql_free_result($rs_active);
			mysql_free_result($rs_clients);
			mysql_free_result($rs_work);
			exit("<nsweep>command=dropwork</nsweep>");
		} else {
			 #don't drop the work; go right ahead
			 
			 $newvalues['lastreply'] = "checked in";
			 
			$newvalues['lastcomm'] = date("Y/m/d H:i:s");
    		$newvalues['status'] = 1;
			if ($row_rs_clients['lastreply'] != "uploaded") {
  				$newvalues['cameon'] = $row_rs_clients['cameon'] + 1;
			}
			
			if ($row_rs_clients['started'] ==0) { 
				$newvalues['started'] = date("Y/m/d H:i:s");
			}
			 
			$newvalues['cblock'] = $_REQUEST['workstart'];
			$newvalues['model'] = $_REQUEST['model'];
			$newvalues['modelversion'] = $_REQUEST['modelversion'];
			$newvalues['clientversion'] = $_REQUEST['clientversion'];
	
			if ($row_rs_clients['timestarted'] == 0) {$workvalues['timestarted'] = date("Y/m/d H:i:s"); }
			$workvalues['clientid'] = $row_rs_clients['clientid'];
			$workvalues['assignment'] = 1; 
			
			
    		$workvalues['checkins'] = $row_rs_work['checkins'] + 1;
			
			if(isset($_REQUEST['pdone'])) { $workvalues['pdone'] =  $_REQUEST['pdone']; }
		}
	}
	
    
	
	$rs_clear = mysql_query("UPDATE nsweep_work SET assignment = 0 WHERE workstart <> ".$row_rs_work['workstart']." AND assignment = 1 AND clientid=".$row_rs_clients['clientid'], $conn_nsweep) or die(mysql_error());
	saverecord($newvalues, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);	
	saverecord($workvalues, $row_rs_work, "nsweep_work", "workid", $conn_nsweep);
	mysql_free_result($rs_active);
	mysql_free_result($rs_clients);
	mysql_free_result($rs_work);
	

#finally, do some setup for the client
	
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

echo "<nsweep>result=success</nsweep>";

?>
