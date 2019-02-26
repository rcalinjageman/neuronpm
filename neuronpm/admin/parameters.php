<?php 
# this page displays a summary of existing parameters
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');

require_once('../Connections/conn_nsweep.php'); 
require_once('parameters_func.php');
?>
<?php
mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT model FROM nsweep_models ORDER BY model ASC";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);

$colname_rs_parameters = "1";
if (isset($_REQUEST['model'])) {
  $colname_rs_parameters = (get_magic_quotes_gpc()) ? $_REQUEST['model'] : addslashes($_REQUEST['model']);
} else {
	if ($totalRows_rs_models > 0) {
	  $insertGoTo = "index.php?page=parameters&model=".$row_rs_models['model'];
	  header(sprintf("Location: %s", $insertGoTo));
	 } else {
	 	exit("At least one <a href='index.php?page=models'>model</a> must be defined first"); 
	 }
}

$query_rs_parameters = sprintf("SELECT paramid, model, number, name, type, ubound, p1, p2, setline, setoperator, list FROM nsweep_params WHERE model = '%s' ORDER BY number ASC", $colname_rs_parameters);
$rs_parameters = mysql_query($query_rs_parameters, $conn_nsweep) or die(mysql_error());
$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
$totalRows_rs_parameters = mysql_num_rows($rs_parameters);
?>

<p class="mainbox">Parameters</p>
<form name="form1" method="post" action="index.php?page=parameters">
<select name="model">
          <?php 
do {  
?>
          <option value="<?php echo $row_rs_models['model']?>" <?php if (!(strcmp($row_rs_models['model'], $_REQUEST['model']))) {echo "SELECTED";} ?>><?php echo $row_rs_models['model']?></option>
          <?php
} while ($row_rs_models = mysql_fetch_assoc($rs_models));
?>
  </select>
<input type="submit" name="Submit" value="Go">
</form>
<?php
if (isset($_REQUEST['message'])) {
	echo "<strong>".$_REQUEST['message']."</strong><br>";
}
?>
<table width="100%" border="1" align="center">
  <tr align="center" class="neg1">
  	<td>name</td>
    <td>model</td>
    <td>number</td>
    <td>type</td>
	<td>ubound</td>
	<td>assign</td>
	<td>values</td>
    <td>up</td>
    <td>down</td>
    <td>delete</td>
  </tr>
  <?php 
  $x = 0;
  $numruns = 1;
  do { 
  	$numruns = $numruns * ($row_rs_parameters['ubound']);
  ?>
  <tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
    <td> <a href="index.php?page=parameters_alter&paramid=<?php echo $row_rs_parameters['paramid']; ?>&model=<?php echo $row_rs_parameters['model']; ?>"> <?php echo $row_rs_parameters['name']; ?></a> </td>
    <td> <?php echo $row_rs_parameters['model']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_parameters['number']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_parameters['type']; ?><?php if ($row_rs_parameters['type'] !="list") {echo "(".$row_rs_parameters['p1'].",".$row_rs_parameters['p1'].")"; }?>&nbsp; </td>
	<td> <?php echo $row_rs_parameters['ubound']; ?>&nbsp; </td>
    <td> <?php echo param_assignline($row_rs_parameters['setline'], $row_rs_parameters['setoperator'], $row_rs_parameters['name'], $row_rs_parameters['number']); ?>&nbsp; </td>
    <td> <?php echo param_vallist($row_rs_parameters['type'], $row_rs_parameters['ubound'], $row_rs_parameters['p1'], $row_rs_parameters['p2'], $row_rs_parameters['list']); ?>&nbsp; </td>
		<td>
	<?php 
	if ($x > 0) { ?>
	  <form name="up" method="get" action="index.php">
	  <input type="submit" name="Submit2" value="Up">
	  <input type="hidden" name="mm_swap" value="Up">
	  <input type="hidden" name="page" value="parameters_swap">
	  <input type="hidden" name="model" value = "<?php echo $row_rs_parameters['model']; ?>">
	  <input type="hidden" name="paramid1" value="<?php echo $row_rs_parameters['paramid']; ?>">
	  <?php 
	  	mysql_data_seek($rs_parameters, $x-1);
		$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	  ?>
  	  <input type="hidden" name="paramid2" value="<?php echo $row_rs_parameters['paramid']; ?>">
	  <?php
	  	mysql_data_seek($rs_parameters, $x);
		$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	  ?>
      </form> 
	<?php }
	?>	</td>
	<td align="center" valign="middle">
	<?php
	if ($x < ($totalRows_rs_parameters-1)) { ?>
	  <form name="up" method="get" action="index.php">
	  <input type="submit" name="Submit2" value="Down">
	  <input type="hidden" name="mm_swap" value="Down">
	  <input type="hidden" name="page" value="parameters_swap">
	  <input type="hidden" name="model" value = "<?php echo $row_rs_parameters['model']; ?>">
	  <input type="hidden" name="paramid1" value="<?php echo $row_rs_parameters['paramid']; ?>">
	  <?php 
	  	mysql_data_seek($rs_parameters, $x+1);
		$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	  ?>
  	  <input type="hidden" name="paramid2" value="<?php echo $row_rs_parameters['paramid']; ?>">
	  <?php
	  	mysql_data_seek($rs_parameters, $x);
		$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	  ?>
      </form> 
	<?php }	?>	</td>
	<td><form name="form2" method="post" action="index.php?page=parameters_del">
	  <input type="submit" name="Submit2" value="Delete">
	  <input type="hidden" name="mm_del" value="mm_del">
	  <input type="hidden" name="model" value = "<?php echo $row_rs_parameters['model']; ?>">
	  <input type="hidden" name="paramid" value="<?php echo $row_rs_parameters['paramid']; ?>">
    </form> </td>
  </tr>
  <?php
  $x++;
   } while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters));
    ?>
</table>
<p><br>
  <?php echo $totalRows_rs_parameters ?> Parameters for this model, requiring <?php echo $numruns;?> runs
  

</p>
<p><a href="index.php?page=parameters_add&model=<?php echo $_REQUEST['model']; ?>">
  <input type="button" name="New" value="New">
  </a>
    <?php
mysql_free_result($rs_parameters);
?>
</p>
<p>These are the parameters belonging to the selected model. Click the name of the paramter to edit it. The ASSIGN column shows how the paramter will be used to alter a variable in your model. The VALUES column shows the values it takes on. It is a good idea to move the least important parameter to the top. You will than have a sub-analysis omitting that paramter ready early in your sweep. Note the calculated number of runs required for the given parameter set--make sure it is reasonable given the time/run and available client pool.</p>
