<?php 
# this page deletes parameters
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

if ((isset($_REQUEST['paramid'])) && ($_REQUEST['paramid'] != "") && (isset($_REQUEST['mm_del']))) {
  $deleteSQL = sprintf("DELETE FROM nsweep_params WHERE paramid=%s",
                       GetSQLValueString($_REQUEST['paramid'], "int"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($deleteSQL, $conn_nsweep) or die(mysql_error());
  
  #now re-order the parameters
	$query_rs_parameters = "SELECT model, number, paramid FROM nsweep_params WHERE model = '".$_REQUEST['model']."' ORDER BY number ASC;";
	$rs_parameters = mysql_query($query_rs_parameters, $conn_nsweep) or die(mysql_error());
	$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	$totalRows_rs_parameters = mysql_num_rows($rs_parameters);
  $x = 1;
  do {
	  $updateSQL = sprintf("UPDATE nsweep_params SET number=%s WHERE paramid=%s",
                       GetSQLValueString($x, "int"),
                       GetSQLValueString($row_rs_parameters['paramid'], "int"));
	  mysql_select_db($database_conn_nsweep, $conn_nsweep);
	  $Result1 = mysql_query($updateSQL, $conn_nsweep) or die(mysql_error());
	  $x++;
  } while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters));

  $deleteGoTo = "index.php?page=parameters&message=Deleted ".$_REQUEST['paramid']."&model=".$_REQUEST['model'];
 header(sprintf("Location: %s", $deleteGoTo));
}
?>
