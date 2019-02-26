<?php
# this page displays a summary of existing models known to the server
# and provides links for initializing, publishing, and pausing models
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('parameters_func.php');
require_once('../Connections/conn_nsweep.php'); ?>

<?php
mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT    `nsweep_models`.`model`,   `nsweep_models`.`startfile`,   `nsweep_models`.`version`,   `nsweep_models`.`comments`,   `nsweep_models`.`blocksize`,   `nsweep_models`.`reportline`,   `nsweep_models`.`inlinereport`,   `nsweep_models`.`runsneeded`,   `nsweep_models`.`active`,  COUNT(`nsweep_work`.`model`) AS `wcount` FROM   `nsweep_work`   RIGHT OUTER JOIN `nsweep_models` ON (`nsweep_work`.`model` = `nsweep_models`.`model`)  GROUP BY   `nsweep_models`.`model`,   `nsweep_models`.`startfile`,   `nsweep_models`.`version`,   `nsweep_models`.`comments`,   `nsweep_models`.`blocksize`,   `nsweep_models`.`reportline`,   `nsweep_models`.`inlinereport`,   `nsweep_models`.`runsneeded`,   `nsweep_models`.`active` ORDER BY   `nsweep_models`.`active` DESC,   `nsweep_models`.`model`";
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
    <td># Params</td>
	<td>Runs</td>
	<td>Uploaded?</td>
    <td>Initialized?</td>
	<td>Params.hoc</td>
	<td>Active?</td>
	<td>Actions</td>
  </tr>

 <?php 
  $x = 0;
  do { 
  $modelfileexists = file_exists(BASE."/models/".$row_rs_models['model']."/simfiles/".$row_rs_models['startfile']);
  $pchars = param_char($row_rs_models['model'], $database_conn_nsweep, $conn_nsweep);
?>
  <tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
    	<td><?php echo $row_rs_models['model']; ?></td>
   		<td> <?php echo $row_rs_models['version']; ?>&nbsp; </td>
	    <td> <?php echo $pchars['pcount']; ?>&nbsp; </td>
		<td> <?php echo $pchars['runsneeded'];" (".$row_rs_models['blocksize'].")"; ?></td>
		<td> <?php if($modelfileexists) { echo "Y"; } else { echo "N";} ?></td>
		<td> <?php if ($row_rs_models['wcount'] > 0) {echo "Y"; } else {echo "N";} ?>&nbsp; </td>
		<td> <?php
		$paramshoc =  BASE."/models/".$row_rs_models['model']."/params.hoc";
		if (file_exists($paramshoc)) {
			echo '<a href="../models/'.$row_rs_models['model'].'/params.hoc" target="blank">View</a>';
		} else {
			echo "N";
		}
		  ?></td>
    	<td> <?php if ($row_rs_models['active'] > 0) {echo "Y"; } else {echo "N";} ?></td>
		<td>
		<?php 
			if (($pchars['pcount'] > 0) && ($row_rs_models['wcount'] == 0)) {
				#can be initialized
				echo "<a href='index.php?page=init_initialize&model=".$row_rs_models['model']."'>Initialize</a><br>";
			}
			if (($row_rs_models['active'] == 0 ) && ($row_rs_models['wcount'] > 0) && ($modelfileexists)) {
				echo "<a href='index.php?page=init_activate&model=".$row_rs_models['model']."'>Activate</a><br>";
			}
			if (($row_rs_models['active'] == 1)) {
				echo "<a href='index.php?page=init_pause&model=".$row_rs_models['model']."'>Pause</a><br>";
			}
			if (($row_rs_models['wcount'] > 0) && ($row_rs_models['active'] == 0)) {
				echo "<a href='index.php?page=init_clear&&mm_del=mm_del&model=".$row_rs_models['model']."'>Clear</a><br>";
			}
		?>
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
</p>
<?php
mysql_free_result($rs_models);
?>
<p><br>
  To be published, a model requires:</p>
<ol>
  <li>A paramter set</li>
  <li>The model must be uploaded (which this script detects by looking for the start file in the /models/model name/simfiles directory)</li>
  <li>The model must be initialized. This process creates the work assignments for the model and creates the requisite hoc code for assigning parameter values (params.hoc stored in /models/model name/ directory).</li>
  <li>The model must be set to active. Only one model is active at a time, but an active model may be paused to take it off line.</li>
</ol>
<p>Hitting &lt;initialize&gt; will create the work assignments (stored in table work) and create params.hoc.<strong> If params.hoc was previously created, it will be deleted and overwritten (wiping out any customizations you made to the file).</strong> You can view this file via the view link under params.hoc. </p>
<p>Hitting &lt;clear&gt; will clear out all the work assignments for a model--but it will not delete params.hoc nor will it delete any files uploaded if the sweep had been running. You use this function if you've made a paramter change after having initialized the function.</p>
<p>Hitting &lt;activate&gt; will publish the model and make it available to clients that check in with the server. YOU'VE GONE LIVE. If another model was active, it will be paused--NSWEEP currently supports only one active sweep at a time. </p>
<p>Hitting &lt;pause&gt; will take a model off-line.</p>
