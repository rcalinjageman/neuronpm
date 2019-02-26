<?php 
# this page displays a summary of existing parameters
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('../Connections/conn_nsweep.php'); 
?>

<?php
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

function saverecord($newvalues, $table, $keycolumn, $conn) {
		$updateSQL = "UPDATE `".$table."` SET ";
		$setline = "";
		reset($newvalues);
		
		while($key = key($newvalues)) {
			if ($key != $keycolumn) {
				if (strlen($setline) != 0) { $setline .= ", "; }
				$setline.= sprintf("`%s` = %s", $key, GetSQLValueString($newvalues[$key], "text"));
			}
			next($newvalues);
		}
		
		if (strlen($setline) > 0) {
			$updateSQL = $updateSQL.$setline." WHERE `".$keycolumn."` = ".GetSQLValueString($newvalues[$keycolumn], "text");
			$rs_clients = mysql_query($updateSQL, $conn) or die(mysql_error());
		}
}

function getqstring($field, $start) {
	$queryString_rs_clients = "";
  		$params = explode("&", $start);
  		$newParams = array();
  		foreach ($params as $param) {
    		if (stristr($param, $field) == false) {
     			 array_push($newParams, $param);
   			 }
  			}
  		if (count($newParams) != 0) {
  			  $queryString_rs_clients = "&" . htmlentities(implode("&", $newParams));
			   $queryString_rs_clients = str_replace("&&", "&",  $queryString_rs_clients);
  		}
	return str_replace("amp;", "", $queryString_rs_clients);
}

$changethis = array();

if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
  
    if (stristr($param, "changekey_") != false) {
		list($key, $value) = explode("=", $param);
      	$changethis[str_replace("changekey_", "", $key)] = $value;
	 }
	 
  }
  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  saverecord($changethis, "nsweep_work", "workid", $conn_nsweep);
}
	
	
	$insertGoTo = getqstring("page", $_SERVER['QUERY_STRING']);;
  	$insertGoTo = getqstring("changekey_", $insertGoTo);
	$insertGoTo = getqstring("nextpage", $insertGoTo);
	$insertGoTo = "index.php?page=".$_REQUEST['nextpage'].$insertGoTo;

	header(sprintf("Location: %s", $insertGoTo));
?>