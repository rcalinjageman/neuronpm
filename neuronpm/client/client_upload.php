<?php 
# this page allows a client upload work
#  
#
# Bob Calin-Jageman
echo $_REQUEST['inlinereport'];
# should start all sub pages to prevent outside access
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


if (!is_uploaded_file($_FILES['workfile']['tmp_name']) ) 
	{
		echo "<nsweep>fail=no workfile sent</nsweep>";
		exit;
	}

if (!file_exists(BASE. "/models/" . $_GET['model'] . "/reports/"))
	{
		echo "<nsweep>fail=storage area doesn't exist</nsweep>";
		exit;
	} 

if (file_exists(BASE. "/models/" . $_GET['model'] . "/reports/". $_FILES['workfile']['name'])) {
		echo "<nsweep>fail=exists</nsweep>";
	} else {
		copy($_FILES['workfile']['tmp_name'], BASE. "/models/" . $_GET['model'] . "/reports/" . $_FILES['workfile']['name']);
	}

if (($_REQUEST['inlinereport'] == "0") || (substr($_FILES['workfile']['name'], 0, 2) == 'in')) {
		
	
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
	$saveclient['lastreply'] = "uploaded";
	$saveclient['blockscomplete'] = $row_rs_clients['blockscomplete'] + 1;
	$saveclient['cblock'] = 0;
	
	saverecord($saveclient, $row_rs_clients, "nsweep_clients", "clientid", $conn_nsweep);
	
	$updatesql = sprintf("SELECT * FROM `nsweep_work` WHERE `model`=%s AND workstart = %s LIMIT 1 ;",
		GetSQLValueString($_REQUEST['model'], "text"),
		GetSQLValueString($_REQUEST['workstart'], "long"));
	$rs_work = mysql_query($updatesql, $conn_nsweep) or die("");
	$row_rs_work = mysql_fetch_assoc($rs_work);
		
	$savework = array();
	$savework['assignment'] = -1;
	$savework['pdone'] = 100;
	$savework['timeon'] = $row_rs_work['timeon'] + $timeon;
	$savework['timefinished'] = date("Y/m/d H:i:s");
	
	saverecord($savework, $row_rs_work, "nsweep_work", "workid", $conn_nsweep);
	mysql_free_result($rs_work);	
	mysql_free_result($rs_clients);
	
	echo "<nsweep>checkedout=true</nsweep>";
	}


echo "<nsweep>success=true</nsweep>";



?>