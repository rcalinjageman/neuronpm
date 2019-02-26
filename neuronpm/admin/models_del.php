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

if ((isset($_REQUEST['model'])) && ($_REQUEST['model'] != "") && (isset($_REQUEST['MM_del']))) {
  $deleteSQL = sprintf("DELETE FROM nsweep_models WHERE model=%s",
                       GetSQLValueString($_REQUEST['model'], "text"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($deleteSQL, $conn_nsweep) or die(mysql_error());

  $deleteGoTo = "index.php?page=models&message=Deleted ".$_REQUEST['model'];

header(sprintf("Location: %s", $deleteGoTo));
}
echo "deleted";
?>
