<?php 
# this page edits an existing model
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

	#makes a directory stucture if it doesn't exist.  repeated from models_add (needs work)
	$modelroot = BASE. "/models/" . $_POST['newmodel'];
	
	if(!file_exists($modelroot )) {
		mkdir($modelroot );
		$message .=" created model directory; ";
	}
	
	if(!file_exists($modelroot . "/reports")) {
		mkdir($modelroot  . "/reports");
		$message .=" created model report directory; ";
	}
	
	if(!file_exists($modelroot . "/simfiles")) {
		mkdir($modelroot  . "/simfiles");
		$message .=" created model simfile directory; ";
	}


  $updateSQL = sprintf("UPDATE nsweep_models SET model=%s, startfile=%s, version=%s, comments=%s, blocksize=%s, reportline=%s, inlinereport=%s WHERE model=%s",
  					   GetSQLValueString($_POST['newmodel'], "text"),
                       GetSQLValueString($_POST['startfile'], "text"),
                       GetSQLValueString($_POST['version'], "int"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['blocksize'], "int"),
                       GetSQLValueString($_POST['reportline'], "text"),
                       GetSQLValueString(isset($_POST['inlinereport']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['model'], "text"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($updateSQL, $conn_nsweep) or die(mysql_error());

  $updateGoTo = "index.php?page=models&message=Updated ".$_REQUEST['newmodel'];
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT * FROM nsweep_models WHERE nsweep_models.model ='".$_REQUEST['model']."';";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);
 

mysql_free_result($rs_models);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Model:</td>
      <td><input name="newmodel" type="text" id="newmodel" value="<?php echo $row_rs_models['model']; ?>" size="25" maxlength="25"> </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Startfile:</td>
      <td><input name="startfile" type="text" value="<?php echo $row_rs_models['startfile']; ?>" size="25" maxlength="25"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Version:</td>
      <td><input name="version" type="text" value="<?php echo $row_rs_models['version']; ?>" size="5" maxlength="5"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Comments:</td>
      <td>
        <textarea name="comments" cols="50" rows="5"><?php echo $row_rs_models['comments']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Blocksize:</td>
      <td><input type="text" name="blocksize" value="<?php echo $row_rs_models['blocksize']; ?>" size="50"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Reportline:</td>
      <td>
        <textarea name="reportline" cols="50" rows="15"><?php echo $row_rs_models['reportline']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inlinereport:</td>
      <td><input type="checkbox" name="inlinereport" value=""  <?php if (!(strcmp($row_rs_models['inlinereport'],1))) {echo "checked";} ?>></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
	  <?php if ($row_rs_models['active']  == 0) { ?>
      <td><input type="submit" value="Update"></td>
	  <?php } else { ?>
	   	<b>Can't alter model while it is active.</b>
	  <?php } ?>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="model" value="<?php echo $row_rs_models['model']; ?>">
</form>
<p>note: Changing a model's name will make a new directory structure based on the new name. However, it will not copy over files in the existing directory structure--you will have to manually move these files yourself. </p>
