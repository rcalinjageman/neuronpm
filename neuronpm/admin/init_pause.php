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
?>
<?php
if (isset($_REQUEST['model'])) {

	$colname_rs_models = $_REQUEST['model'];
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	
	$query_rs_models = "UPDATE nsweep_models SET active = 0 WHERE active = 1";
	$rs_inactive = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
	mysql_free_result($rs_inactive);

	$message = "Paused ".$_REQUEST['model'];
	
	$insertGoTo = "index.php?page=init&message=".$message;
 	header(sprintf("Location: %s", $insertGoTo));
	
}
?>