<?php
# this is the checkout for nsweep clients
# 
# Bob Calin-Jageman

#validation
require_once("../client_ini.php");
if (!defined('BASE')) exit('');
require_once("../Connections/conn_nsweep.php");

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
		reset($newvalues);
		$updateSQL = "UPDATE `".$table."` SET ";
		$setline = "";
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

	#client has been validated, now do checkout
	
	#first, check out the client
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_clients = sprintf("SELECT * FROM nsweep_clients WHERE ip = '%s' AND host='%s'", $_SERVER['REMOTE_ADDR'], $_REQUEST['host']);
	$rs_clients = mysql_query($query_rs_clients, $conn_nsweep) or die($rs_clients);
	$row_rs_clients = mysql_fetch_assoc($rs_clients);
	
	$saveclient = array();
	$saveclient['status'] = 0;
	$saveclient['lastcomm'] = date("Y/m/d H:i:s");
	$saveclient['lastmess'] = $_SERVER['QUERY_STRING'];
	$timeon = (strtotime(date("Y/m/d H:i:s")) - strtotime($row_rs_clients['lastcomm']));
	$saveclient['timeon'] = $row_rs_clients['timeon'] + $timeon;
	$saveclient['lastreply'] = "checked out";
	saverecord($saveclient, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);
	
	
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_work = "SELECT * FROM `nsweep_work` WHERE (`clientid` = '".$row_rs_clients['clientid']."') AND (`workstart` = '".$_REQUEST['workstart']."') ORDER BY `nsweep_work`.`workstart`";
	$rs_work = mysql_query($query_rs_work, $conn_nsweep) or die("");
	$row_rs_work = mysql_fetch_assoc($rs_work);
		
	$savework = array();
	if(isset($_REQUEST['pdone'])) { $savework['pdone'] = $_REQUEST['pdone']; }
	$savework['timeon'] = $row_rs_work['timeon'] + $timeon;
	
	saverecord($savework, $row_rs_work, "nsweep_work", "workid", $conn_nsweep);
	mysql_free_result($rs_clients);
	mysql_free_result($rs_work);	
	echo "<nsweep>success=true</nsweep>";
	echo "<nsweep>timeon=".$timeon."</nsweep>";
?>