<?php 
# this page adds a new parameter
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_pcount = sprintf("SELECT    COUNT(`nsweep_params`.`model`) AS `pcount` FROM `nsweep_params` WHERE   (`nsweep_params`.`model` = '%s')",$_REQUEST['model']);
	$rs_pcount = mysql_query($query_rs_pcount, $conn_nsweep) or die(mysql_error());
	$row_rs_pcount = mysql_fetch_assoc($rs_pcount);
	$totalRows_rs_pcount = mysql_num_rows($rs_pcount);
	$number = 1;
	if ($totalRows_rs_pcount > 0 && $row_rs_pcount['pcount'] > 0) { $number = $row_rs_pcount['pcount'] + 1; }
	echo $_REQUEST['type'];
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

	
  $insertSQL = sprintf("INSERT INTO nsweep_params (model, number, name, setline, setoperator, type, ubound, p1, p2, list, active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_REQUEST['model'], "text"),
                       GetSQLValueString($number, "int"),
                       GetSQLValueString($_REQUEST['name'], "text"),
                       GetSQLValueString($_REQUEST['setline'], "text"),
                       GetSQLValueString($_REQUEST['setoperator'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($ubound, "int"),
                       GetSQLValueString($p1, "double"),
                       GetSQLValueString($p2, "double"),
                       GetSQLValueString($list, "text"),
                       GetSQLValueString($_POST['active'], "int"));
  $Result1 = mysql_query($insertSQL, $conn_nsweep) or die(mysql_error());
	mysql_free_result($rs_pcount);
   mysql_free_result($Result1);
  $insertGoTo = "index.php?page=parameters&message=Added ".$_REQUEST['name']."&model=".$_REQUEST['model'];
 header(sprintf("Location: %s", $insertGoTo));
 #exit();
}
?> 

<?php
mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT model FROM nsweep_models ORDER BY model ASC";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
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
  $rows = mysql_num_rows($rs_models);
  if($rows > 0) {
      mysql_data_seek($rs_models, 0);
	  $row_rs_models = mysql_fetch_assoc($rs_models);
  }
?>
        </select><br>
		(Select the model this parameter should belong to)<br>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input name="name" type="text" value="" size="25" maxlength="25"><br>
	  (Give the parameter a name)<br></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Model variable:</td>
      <td>
        <input name="setline" type="text" value="" size="50" maxlength="50">
        </textarea><br>
		(Type the exact variable or obj this parameter should alter in your model.  NSweep will generate the appropriate hoc code)<br>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Operator</td>
      <td>
		<select name="setoperator">
          <option value="=" >=</option>
          <option value="+" >+</option>
          <option value="*" >*</option>
       </select><br>
	   (Select the way this paramter will control your the model variable)<br>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td>
        <select name="type">
          <option value="line" >line</option>
          <option value="exp" >exp</option>
          <option value="list" >list</option>
        </select><br>
		(Select the way the paramter will vary (linearly, exponentially, or just a list of given values)<br>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Ubound:</td>
      <td><input type="text" name="ubound" value="" size="7"><br>
	  (Type the total number of values that parameter will take on. The parameter will start at 0 and go to Ubound -1. )<br></td>
    </tr>
    <tr valign="baseline">
     <td nowrap align="right">P1:</td>
      <td><input type="text" name="p1" value="" size="7"><br>
	  (If parameter is line type, fill in the slope [ =(p1 * x) + p2]; If it is exponential, fill in the base [ = p1 ^ (x + p2) ] )<br></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">P2:</td>
      <td><input type="text" name="p2" value="" size="7"><br>
	  (If the parameters is line tyep, fill in the intercept; If it is exponential, fill in the first power to be used)<br></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">List:</td>
      <td><input name="list" type="text" value="" size="50" maxlength="255"><br>
	  (If the paramter is a list, fill in a comma seperated list of NUMBERS and DO NOT fill in a UBOUND, P1, or P2)<br>
	  "
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Add"></td>
    </tr>
  </table>
  <input type="hidden" name="number" value="0">
  <input type="hidden" name="active" value="0">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_models);
?>
