<?php 
# this page deletes a model; it does not check to ensure it is ok to delete (that logic is in models.php)
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

if ((isset($_REQUEST['clientid'])) && ($_REQUEST['clientid'] != "") && (isset($_REQUEST['MM_del']))) {
  $deleteSQL = sprintf("DELETE FROM nsweep_clients WHERE clientid=%s",
                       GetSQLValueString($_REQUEST['clientid'], "text"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($deleteSQL, $conn_nsweep) or die(mysql_error());

  $deleteGoTo = "index.php?page=clients&message=Deleted&".$_REQUEST['clientid']."&form_status=-99&form_approved=-99";

header(sprintf("Location: %s", $deleteGoTo));
}
echo "deleted";
?>
