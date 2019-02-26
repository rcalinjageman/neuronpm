<?php
# this page displays a summary of existing models known to the server
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('parameters_func.php');
require_once('../Connections/conn_nsweep.php'); ?>

<?php
mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT    `nsweep_models`.`model`,   `nsweep_models`.`startfile`,   `nsweep_models`.`version`,   `nsweep_models`.`comments`,   `nsweep_models`.`blocksize`,   `nsweep_models`.`reportline`,   `nsweep_models`.`inlinereport`,   `nsweep_models`.`runsneeded`,   `nsweep_models`.`active`,  COUNT(`nsweep_work`.`model`) AS `wcount` FROM   `nsweep_work`   RIGHT OUTER JOIN `nsweep_models` ON (`nsweep_work`.`model` = `nsweep_models`.`model`)   GROUP BY   `nsweep_models`.`model` ORDER BY   `nsweep_models`.`active` DESC,   `nsweep_models`.`model`";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);
?>
<link href="../style.css" rel="stylesheet" type="text/css">

<p class="mainbox">Models</p>
<?php
if (isset($_REQUEST['message'])) {
	echo "<strong>".$_REQUEST['message']."</strong><br>";
}
?>
<table width="100%" border="1" align="center">
  <tr align="center" class="neg1">
    <td>Name</td>
    <td>Version</td>
	<td>Uploaded</td>
    <td>Active?</td>
    <td># Params</td>
    <td>Initialized?</td>
	<td>Actions</td>
	<td>Actions</td>
  </tr>

 <?php 
  $x = 0;
  do { 
  $pchars = param_char($row_rs_models['model'], $database_conn_nsweep, $conn_nsweep)
?>
  <tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
    	<td> <a href="index.php?page=models_alter&model=<?php echo $row_rs_models['model']; ?>"> <?php echo $row_rs_models['model']; ?>&nbsp; </a> </td>
   	<td> <?php echo $row_rs_models['version']; ?>&nbsp; </td>
		<td> <?php if(file_exists(BASE."/models/".$row_rs_models['model']."/simfiles/".$row_rs_models['startfile'])) { echo "Y"; } else { echo "N";} ?></td>
    	<td><?php if ($row_rs_models['active'] > 0) {echo "Y"; } else {echo "N";} ?>&nbsp; </td>
    	<td> <?php echo $pchars['pcount']; ?>&nbsp; </td>
    	<td> <?php if ($row_rs_models['wcount'] > 0) {echo "Y"; } else {echo "N";} ?>&nbsp; </td>
		<td>
		<form method="post" name="paramform" action="index.php?page=parameters">
		  <input type="submit" value="Params">
		  <input type="hidden" name="model" value="<?php echo $row_rs_models['model']; ?>">
		</form>
		</td>
		<td>
		<?php 		if ($row_rs_models['active'] == 0) {		?>
		<form method="post" name="delform" action="index.php?page=models_del">
		  <input type="submit" value="Delete">
		  <input type="hidden" name="model" value="<?php echo $row_rs_models['model']; ?>">
		  <input type="hidden" name="MM_del" value="MM_del">
		</form>
		<?php } ?>
		</td>
  </tr>
<?php 
		if ($row_rs_models['active'] == 1) { echo "<tr></tr><tr></tr><tr></tr><tr></tr>"; }
  		$x++;
	} while ($row_rs_models = mysql_fetch_assoc($rs_models)); 
?>
</table>
<p><?php echo $totalRows_rs_models ?> Models Total 
</p>
<p>
  <a href="index.php?page=models_add"><input type="button" name="New" value="New"></a>
</p>
<?php
mysql_free_result($rs_models);
?>
<br>
note: deleting a model does not delete it's file structure on the server. It will, however, delete all params and work associated with the model. <br>
<br>
The first step in using NSweep is to tell the server about the existing Neuron model you have that you want NSweep to explore.<br>
1) Click ADD and fill out information about the model; this also creates a directory structure for the model.
2) Upload the files defining the model to the server (nsweep/models/model name/simfiles)
3) Go to the parameters section to define the parameters you'll vary.