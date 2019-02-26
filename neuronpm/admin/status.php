<?php
# this page displays current NSweep status
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
	if (!defined('BASE')) exit('');
	require_once('../Connections/conn_nsweep.php'); 

	mysql_select_db($database_conn_nsweep, $conn_nsweep);
	$query_rs_models = "SELECT * FROM nsweep_models WHERE active = 1";
	$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
	$row_rs_active = mysql_fetch_assoc($rs_active);
	
	if (PASS=='pword') {echo "**: Admin password is set to default.  You can set a new password <a href='index.php?page=password'>here</a><br><br>"; }
	
	if (mysql_num_rows($rs_active) != 1) { 
		echo "**: No models currently online.  You'll need to create a model, setup parameters, and initialize it to publish a model for your clients (see the CREATE menu at left).<br>";
		mysql_free_result($rs_active);
		exit();
		}
	
	$model = $row_rs_active['model'];
	$blocksize = $row_rs_active['blocksize'];
	
	echo "Published model: ".$model;
	mysql_free_result($rs_active);
	

	$query_rs_models = "SELECT COUNT(`nsweep_work`.`workid`) AS `countwork`,`nsweep_work`.`assignment` FROM `nsweep_work` WHERE (`nsweep_work`.`model` = '".$model."') GROUP BY `nsweep_work`.`assignment`";
	$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
	$totalwork = 0;
	$inactivework = 0;
	$activework = 0;
	$finishedwork = 0;
	
	while ($row_rs_active = mysql_fetch_assoc($rs_active)) {
		$totalwork = $totalwork + $row_rs_active['countwork'];
		if ($row_rs_active['assignment'] == 1) { 
			$activework = $row_rs_active['countwork']; 
		} else {
			if ($row_rs_active['assignment'] == -1) { 
				$finishedwork = $row_rs_active['countwork'];
			} else {
				$inactivework = $inactivework + $row_rs_active['countwork'];
			}
		}
	}
	
	mysql_free_result($rs_active);
	
	
	$query_rs_models = "SELECT COUNT(`nsweep_clients`.`clientid`) AS `countclients`,`nsweep_clients`.`status`, `nsweep_clients`.`approved` FROM `nsweep_clients` GROUP BY `nsweep_clients`.`status`, `nsweep_clients`.`approved`";
	$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
	$totalclients = 0;
	$approvedclients = 0;
	$bannedclients = 0;
	$unknownclients = 0;
	$workingclients = 0;
	$offlineclients = 0;
	while ($row_rs_active = mysql_fetch_assoc($rs_active)) {
		if ($row_rs_active['approved'] == 1) {
			$approvedclients = $row_rs_active['countclients'];
		 } else {
			if ($row_rs_active['approved'] == -1) {
				$bannedclients = $row_rs_active['countclients']; 
			} else {
				$unknownclients = $unknownclients + $row_rs_active['countclients'];
			}
		}
		$totalclients = $totalclients + $row_rs_active['countclients'];
		
		if ($row_rs_active['status'] == 1) {
			$workingclients = $row_rs_active['countclients'];
		} else {
			$offlineclients = $offlineclients + $row_rs_active['countclients'];
		}
	}
?>
<table>
	<tr class="neg1">
		<td colspan="3"><?php echo $model; ?>: Work</td>
	</tr>
	<tr class="neg3">
		<td>Finished</td>
		<td><?php echo $finishedwork; ?></td>
		<td><?php printf("%03.2f", (($finishedwork/$totalwork)*100)); ?>%</td>
	</tr>
	<tr class="neg3">
		<td>Checked Out</td>
		<td><?php echo $activework; ?></td>
		<td><?php printf("%03.2f", (($activework/$totalwork)*100)); ?>%</td>
		</tr>
	<tr class="neg3">
		<td>Queued</td>
		<td><?php echo $inactivework;?></td>
		<td><?php printf("%03.2f", (($inactivework/$totalwork)*100)); ?>%</td>
	</tr>
	<tr class="neg3">
		<td>Total</td>
		<td><?php echo $totalwork; ?></td>
		<td></td>
	</tr class="neg1">
</table>

<br>
<table>
	<tr class="neg1">
		<td colspan="2"><?php echo $model; ?>: Clients</td>
	</tr>
	<tr class="neg3">
		<td>Working</td>
		<td><?php echo $workingclients; ?></td>
	</tr>
	<tr class="neg3">
		<td>Offline</td>
		<td><?php echo $offlineclients; ?></td>
	</tr>
	<tr><td colspan="2"><br></br></td></tr>
	<tr class="neg3">
		<td>Known</td>
		<td><?php echo $approvedclients; ?></td>
	</tr>
	<tr class="neg3">
		<td>Need approved</td>
		<td><?php echo $unknownclients; ?></td>
	</tr>
	<tr class="neg3">
		<td>Banned</td>
		<td><?php echo $bannedclients; ?></td>
	</tr>
</table>
<br>
<br><br>
<? if (APPROVEDONLY) {
		echo "Security: Only approved clients allowed.";
	} else {
		echo "Security: Open to all non-banned cleints";
	};
	echo "<br>";
	echo "All data files are uploaded to: <a href='../models/".$model."/reports'>".BASE."/models/".$model."/reports</a>";
	
	?>