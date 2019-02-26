<?php # this page displays a summary of existing models known to the server
# and provides links for initializing, publishing, and pausing models
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('../Connections/conn_nsweep.php');
require_once('parameters_func.php');
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
?>

<?php

if (isset($_REQUEST['model'])) {

	$colname_rs_models = $_REQUEST['model'];
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	
	$message = "Initialized work for ".$_REQUEST['model'].".";
	$message = $message.param_write_params($_REQUEST['model'], $database_conn_nsweep, $conn_nsweep);
	
	$query_rs_models = sprintf("SELECT * FROM nsweep_models WHERE model = '%s'", $colname_rs_models);
	$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
	$row_rs_models = mysql_fetch_assoc($rs_models);	
	$totalRows_rs_models = mysql_num_rows($rs_models);
	
	if ($totalRows_rs_models == 0) { exit("no such model"); };
	
	$paramchar = param_char($_REQUEST['model'], $database_conn_nsweep, $conn_nsweep);
	$numruns = $paramchar['runsneeded'];
	$blocksize = $row_rs_models['blocksize'];
	
	if (($ws + $blocksize) > $numruns) { $blocksize = ($numruns - $ws); }
	
	for($ws = 0; $ws < $numruns; $ws = $ws + $blocksize) {
		 if (($ws + $blocksize) > $numruns) { $blocksize = ($numruns - $ws); }
	
		  $insertSQL = sprintf("INSERT INTO nsweep_work (model, workstart, blocksize) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_rs_models['model'], "text"),
                       GetSQLValueString($ws, "int"),
                       GetSQLValueString($blocksize, "int"));
			
			$Result1 = mysql_query($insertSQL, $conn_nsweep) or die(mysql_error());
	}
	
	$message = "Initialized work for ".$_REQUEST['model'].".";
	$message = $message.param_write_params($_REQUEST['model'], $database_conn_nsweep, $conn_nsweep);
	
	mysql_free_result($rs_models);
	
	$insertGoTo = "index.php?page=init&message=".$message;
 	header(sprintf("Location: %s", $insertGoTo));
}
?>


<?php


?>
