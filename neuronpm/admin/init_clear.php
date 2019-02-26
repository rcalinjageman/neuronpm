<?php 
# this page deletes the work assigned to a model
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('../Connections/conn_nsweep.php'); ?>

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

if ((isset($_REQUEST['model'])) && ($_REQUEST['model'] != "") && (isset($_REQUEST['mm_del']))) {
  $deleteSQL = sprintf("DELETE FROM nsweep_work WHERE model=%s",
                       GetSQLValueString($_REQUEST['model'], "text"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($deleteSQL, $conn_nsweep) or die(mysql_error());
  
 	$message = "Deleted work for ".$_REQUEST['model'];
	
	$insertGoTo = "index.php?page=init&message=".$message;
 	header(sprintf("Location: %s", $insertGoTo));
}

?>
 
 