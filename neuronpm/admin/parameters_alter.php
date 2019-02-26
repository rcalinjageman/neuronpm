<?php 
# this page edits a parameter
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('parameters_func.php');
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
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
		
	if ($_REQUEST['type'] != "list") {
		$list = " ";
		$ubound = $_REQUEST['ubound'];
		$p1 = $_REQUEST['p1'];
		$p2 = $_REQUEST['p2'];
	} else {
		$list = $_REQUEST['list'];
		$listarray = explode(",", $list);
		$p1 = 0;
		$p2 = 0;
		$ubound = sizeof($listarray) - 1;
	}

  $updateSQL = sprintf("UPDATE nsweep_params SET model=%s, name=%s, number=%s, setline=%s, setoperator=%s, type=%s, ubound=%s, p1=%s, p2=%s, list=%s, active=%s WHERE paramid=%s",
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['number'], "int"),
                       GetSQLValueString($_POST['setline'], "text"),
                       GetSQLValueString($_POST['setoperator'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($ubound, "int"),
                       GetSQLValueString($p1, "double"),
                       GetSQLValueString($p2, "double"),
                       GetSQLValueString($list, "text"),
                       GetSQLValueString($_POST['active'], "int"),
                       GetSQLValueString($_POST['paramid'], "int"));

  mysql_select_db($database_conn_nsweep, $conn_nsweep);
 
  $Result1 = mysql_query($updateSQL, $conn_nsweep) or die(mysql_error());
	
 #model has been added, return to models.php with a success message
  $insertGoTo = "index.php?page=parameters&model=".$_REQUEST['model']."&message=updated ".$_REQUEST['name'];
  mysql_free_result($Result1);
  mysql_free_result($rs_pcount);
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT model FROM nsweep_models ORDER BY model ASC";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);

mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_parameters = "SELECT * FROM nsweep_params WHERE paramid = ".$_REQUEST['paramid']."; ";
$rs_parameters = mysql_query($query_rs_parameters, $conn_nsweep) or die(mysql_error());
$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
$totalRows_rs_parameters = mysql_num_rows($rs_parameters);


?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Model:</td>
      <td>
        <select name="model">
          <?php 
do {  
?>
          <option value="<?php echo $row_rs_models['model']?>"<?php if (!(strcmp($row_rs_models['model'], $_REQUEST['model']))) {echo "SELECTED";} ?>><?php echo $row_rs_models['model']?></option>
          <?php
} while ($row_rs_models = mysql_fetch_assoc($rs_models));
?>
        </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input name="name" type="text" value="<?php echo $row_rs_parameters['name']; ?>" size="25" maxlength="25"><br>
	  (Give the parameter a name)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Model variable:</td>
      <td><input name="setline" type="text" value="<?php echo $row_rs_parameters['setline']; ?>" size="50" maxlength="50"><br>
	  (Type the exact variable or obj this parameter should alter in your model.  NSweep will generate the appropriate hoc code)
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Setoperator:</td>
      <td>
        <select name="setoperator">
          <option value="=" <?php if (!(strcmp($row_rs_parameters['setoperator'], "="))) {echo "SELECTED";} ?>>=</option>
          <option value="+" <?php if (!(strcmp($row_rs_parameters['setoperator'], "+"))) {echo "SELECTED";} ?>>+</option>
          <option value="*" <?php if (!(strcmp($row_rs_parameters['setoperator'], "*"))) {echo "SELECTED";} ?>>*</option>
        </select><br>
		(Select the way this paramter will control your the model variable)
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td>
        <select name="type">
          <option value="line" <?php if (!(strcmp($row_rs_parameters['type'], "line"))) {echo "SELECTED";} ?>>line</option>
          <option value="list" <?php if (!(strcmp($row_rs_parameters['type'], "list"))) {echo "SELECTED";} ?>>list</option>
          <option value="exp" <?php if (!(strcmp($row_rs_parameters['type'], "exp"))) {echo "SELECTED";} ?>>exp</option>
        </select><br>
		(Select the way the paramter will vary (linearly, exponentially, or just a list of given values)
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Ubound:</td>
      <td><input type="text" name="ubound" value="<?php echo $row_rs_parameters['ubound']; ?>" size="7"><br>
	  (Type the total number of values that parameter will take on. The parameter will start at 0 and go to Ubound -1.)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">P1:</td>
      <td><input type="text" name="p1" value="<?php echo $row_rs_parameters['p1']; ?>" size="7"><br>
	  (If paramter is line type, fill in the slope [ =(p1 * x) + p2]; If it is exponential, fill in the base [ = p1 ^ (x + p2) ] )</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">P2:</td>
      <td><input type="text" name="p2" value="<?php echo $row_rs_parameters['p2']; ?>" size="7"><br>
	   (If the parameters is line tyep, fill in the intercept; If it is exponential, fill in the first power to be used)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">List:</td>
      <td><input type="text" name="list" value="<?php echo $row_rs_parameters['list']; ?>" size="50"><br>
	  (If the paramter is a list, fill in a comma seperated list of NUMBERS and DO NOT fill in a UBOUND, P1, or P2.)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="paramid" value="<?php echo $row_rs_parameters['paramid']; ?>">
  <input type="hidden" name="number" value="<?php echo $row_rs_parameters['number']; ?>">
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="active" value="<?php echo $row_rs_parameters['active']; ?>">
    <input type="hidden" name="paramid" value="<?php echo $row_rs_parameters['paramid']; ?>">
</form>
Currently, this parameter will be used: 
<?php
echo param_assignline($row_rs_parameters['setline'], $row_rs_parameters['setoperator'], $row_rs_parameters['name'], $row_rs_parameters['number']);
?><br>
And will take values (
<?php
echo param_vallist($row_rs_parameters['type'], $row_rs_parameters['ubound'], $row_rs_parameters['p1'], $row_rs_parameters['p2'], $row_rs_parameters['list']);
?>
)
<?php
mysql_free_result($rs_models);
mysql_free_result($rs_parameters);
?>

