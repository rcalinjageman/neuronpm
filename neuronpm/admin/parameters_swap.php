<?php 
# this page swaps the ordinal position of two parameters
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

if (isset($_REQUEST['mm_swap'])) {
 
  mysql_select_db($database_conn_nsweep, $conn_nsweep);
 
  #now re-order the parameters
	$query_rs_parameters = "SELECT number, paramid FROM nsweep_params WHERE paramid = '".$_REQUEST['paramid1']."' ORDER BY number ASC;";
	$rs_parameters = mysql_query($query_rs_parameters, $conn_nsweep) or die(mysql_error());
	$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	$p1n = $row_rs_parameters['number'];
	
	$query_rs_parameters = "SELECT number, paramid FROM nsweep_params WHERE paramid = '".$_REQUEST['paramid2']."' ORDER BY number ASC;";
	$rs_parameters = mysql_query($query_rs_parameters, $conn_nsweep) or die(mysql_error());
	$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	$p2n = $row_rs_parameters['number'];
	
	$updateSQL = sprintf("UPDATE nsweep_params SET number=%s WHERE paramid=%s",
                       GetSQLValueString($p2n, "int"),
                       GetSQLValueString($_REQUEST['paramid1'], "int"));
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$Result1 = mysql_query($updateSQL, $conn_nsweep) or die(mysql_error());


	$updateSQL = sprintf("UPDATE nsweep_params SET number=%s WHERE paramid=%s",
                       GetSQLValueString($p1n, "int"),
                       GetSQLValueString($_REQUEST['paramid2'], "int"));
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$Result1 = mysql_query($updateSQL, $conn_nsweep) or die(mysql_error());

  $deleteGoTo = "index.php?page=parameters&message=Moved ".$_REQUEST['mm_swap']."&model=".$_REQUEST['model'];
  mysql_free_result($rs_parameters);
  mysql_free_result($Result1);
  header(sprintf("Location: %s", $deleteGoTo));
}
?>