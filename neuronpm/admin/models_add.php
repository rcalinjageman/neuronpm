<?php 
# this page adds a model
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


#we are adding a model
if (isset($_POST["MM_insert"]) && $_REQUEST['MM_insert'] == "add") {
	$comment = $_REQUEST['comments'];
	if (strlen($comment) < 1) { $comment = " "; }


	#make the directory structure if it doesn't exist.
	#most of these operations should probably be abstracted
	#especially this one as it is repeated in models_alter.php
	$modelroot = BASE. "/models/" . $_POST['model'];
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

  $insertSQL = sprintf("INSERT INTO nsweep_models (model, startfile, version, comments, blocksize, reportline, inlinereport, runsneeded, active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['startfile'], "text"),
                       GetSQLValueString($_POST['version'], "int"),
                       GetSQLValueString($comment, "text"),
                       GetSQLValueString($_POST['blocksize'], "int"),
                       GetSQLValueString($_POST['reportline'], "text"),
                       GetSQLValueString(isset($_POST['inlinereport']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['runsneeded'], "int"),
                       GetSQLValueString($_POST['active'], "int"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
  $Result1 = mysql_query($insertSQL, $conn_nsweep) or die(mysql_error());

 #model has been added, return to models.php with a success message
  $insertGoTo = "index.php?page=models&message=Added ".$_REQUEST['model'];
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Model Name*:</td>
      <td><input name="model" type="text" value="" size="25" maxlength="25">
      <br>
	  (This will also be a directory name so don't use spaces and be brief)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Startfile*:</td>
      <td><input name="startfile" type="text" value="" size="25" maxlength="25">
      <br>
	  (Name of the single hoc file which will launch your model; include the extension)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Version*:</td>
      <td><input name="version" type="text" value="1" size="5" maxlength="5">
      <br>
	  (You can give a version number for the model)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Comments:</td>
      <td><input name="comments" type="text" value="" size="50" maxlength="255"></td> 
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Blocksize*:</td>
      <td><input type="text" name="blocksize" value="500" size="50">
      <br>
	  (Number of runs dispatched to a client at a time)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Reportline*:</td>
      <td>
        <textarea name="reportline" cols="50" rows="15"></textarea>
        <br>
		(Literal hoc command for printing the summary report)
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inlinereport*:</td>
      <td><input name="inlinereport" type="checkbox" value="1" >
      <br>
	  (Check yes if you want inline results reported)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Add"></td>
    </tr>
  </table>
  <input type="hidden" name="runsneeded" value="0">
  <input type="hidden" name="active" value="0">
  <input type="hidden" name="MM_insert" value="add">
</form>
<p> When you click ADD, a directory will be made on the server to store your model. It is lodged at NSweep/Models/&lt;Model Name&gt;.<br>
Within the directory for your model will be two subdirectories: 1) simfiles and 2) reports.<br>
The server will store uploaded work for the model in the reports subdirectory.<br>
The simfiles subdirectory is where your model should actually reside (all hoc and mod files, subdirectories, data files, etc.). You should upload your model to this location (Unfortunately, these scripts cannot yet do that for you).<br>
If the server detects the startfile in the appropriate simfile directory, it will consider the model 'uploaded'.</p>

