<?php 
# this page displays a summary of existing parameters
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');

require_once('../Connections/conn_nsweep.php'); 
?>

<?php
mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_models = "SELECT model FROM nsweep_models ORDER BY model ASC";
$rs_models = mysql_query($query_rs_models, $conn_nsweep) or die(mysql_error());
$row_rs_models = mysql_fetch_assoc($rs_models);
$totalRows_rs_models = mysql_num_rows($rs_models);


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_clients = 100;
$pageNum_rs_clients = 0;
if (isset($_GET['pageNum_rs_clients'])) {
  $pageNum_rs_clients = $_GET['pageNum_rs_clients'];
}
$startRow_rs_clients = $pageNum_rs_clients * $maxRows_rs_clients;

$sortby = "workstart";
if (isset($_REQUEST['sortby'])) { $sortby = $_REQUEST['sortby']; }

$assignment = -99;
if (isset($_REQUEST['form_assignment'])) {$assignment = $_REQUEST['form_assignment']; }

$model = $row_rs_models['model'];
if (isset($_REQUEST['form_model'])) {$model = $_REQUEST['form_model']; }

mysql_select_db($database_conn_nsweep, $conn_nsweep);

$query_rs_clients = "SELECT 
  `nsweep_work`.`workid`,
  `nsweep_work`.`model`,
  `nsweep_work`.`workstart`,
  `nsweep_work`.`blocksize`,
  `nsweep_work`.`assignment` + ((`nsweep_work`.`assignment` = 1)  && (`nsweep_clients`.`status` =0 )) AS `assignment`,
  `nsweep_work`.`pdone`,
  `nsweep_work`.`checkins`,
  `nsweep_work`.`timestarted`,
  `nsweep_work`.`timeon`,
  `nsweep_work`.`timefinished`,
  `nsweep_work`.`clientid`,
  `nsweep_clients`.`clientid` as `fclientid`,
  CONCAT(`nsweep_clients`.`ip`, ': ', `nsweep_clients`.`host`) AS `clienttag`,
   ((TO_DAYS(CURDATE()) - TO_DAYS(`nsweep_clients`.`lastcomm`)) * 24) + (HOUR(NOW()) -  HOUR(`nsweep_clients`.`lastcomm`)) as `lastseen`
FROM
  `nsweep_work`
  LEFT OUTER JOIN `nsweep_clients` ON (`nsweep_work`.`clientid` = `nsweep_clients`.`clientid`) WHERE";
  
if ($assignment == -99) {
	$query_rs_clients.= "(`assignment` <> -99) ";
} else {
	if ($assignment == 0) {
		$query_rs_clients.="(`nsweep_work`.`assignment` = 0)";
	} else {
		$query_rs_clients.="( ((`nsweep_work`.`assignment`) + ((`nsweep_work`.`assignment` = 1)  && (`nsweep_clients`.`status` =0 )) ) = ".$assignment.") ";
	}
}


$query_rs_clients.="AND (`nsweep_work`.`model` = '".$model."') ";

$query_rs_clients.= "ORDER BY ".$sortby.", `nsweep_work`.workstart ASC";

$query_limit_rs_clients = sprintf("%s LIMIT %d, %d", $query_rs_clients, $startRow_rs_clients, $maxRows_rs_clients);
# echo $query_rs_clients."<br>";
$rs_clients = mysql_query($query_limit_rs_clients, $conn_nsweep) or die(mysql_error());
$row_rs_clients = mysql_fetch_assoc($rs_clients);

if (isset($_GET['totalRows_rs_clients'])) {
  $totalRows_rs_clients = $_GET['totalRows_rs_clients'];
} else {
  $all_rs_clients = mysql_query($query_rs_clients);
  $totalRows_rs_clients = mysql_num_rows($all_rs_clients);
}
$totalPages_rs_clients = ceil($totalRows_rs_clients/$maxRows_rs_clients)-1;

$queryString_rs_clients = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_clients") == false && 
        stristr($param, "totalRows_rs_clients") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_clients = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_clients = sprintf("totalRows_rs_clients=%d%s", $totalRows_rs_clients, $queryString_rs_clients);

function getqstring($field) {
	$queryString_rs_clients = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
  		$params = explode("&", $_SERVER['QUERY_STRING']);
  		$newParams = array();
  		foreach ($params as $param) {
    		if ((stristr($param, $field) == false) && (stristr($param, "message") == false)) {
     			 array_push($newParams, $param);
   			 }
  			}
  		if (count($newParams) != 0) {
  			  $queryString_rs_clients = "&" . htmlentities(implode("&", $newParams));
			   $queryString_rs_clients = str_replace("&&", "&",  $queryString_rs_clients);
  		}
	}
	return $queryString_rs_clients;
}

function echosort($field, $id, $title) {
	echo "<a href='index.php?".getqstring($field);
	echo "&sortby=".$id."'>".$title;
	echo "</a>";
	
}

?>

<form name="form1" method="get" action="index.php">
model
	<select name="form_model">
          <?php 
			do {  
			?>
    <option value="<?php echo $row_rs_models['model']?>" <?php if (!(strcmp($row_rs_models['model'], $model))) {echo "SELECTED";} ?>><?php echo $row_rs_models['model']?></option>
          <?php
			} while ($row_rs_models = mysql_fetch_assoc($rs_models));
			?>
  	</select>
  assignment
  <select name="form_assignment" id="form_assignment">
    <option value="-99" <?php if ($assignment == -99) { echo "selected"; }?>>all</option>
    <option value="1" <?php if ($assignment == 1) { echo "selected"; }?>>working</option>
	 <option value="2" <?php if ($assignment == 2) { echo "selected"; }?>>checked out</option>
    <option value="0" <?php if ($assignment == 0) { echo "selected"; }?>>queued</option>
	<option value="-1" <?php if ($assignment == -1) { echo "selected"; }?>>finished</option>
  </select> 
  <input type="submit" name="Submit" value="Go">
  <input type="hidden" name="page" value = "work">
  <input type="hidden" name="sortby" value="<?php echo $sortby; ?>">
  </form>
<p>
<?php 

if (isset($_REQUEST['message'])) { echo "<strong>".$_REQUEST['message']."</strong>"; }

?>
&nbsp;</p>
<table border="1" align="center">
  <tr>
  	<td>actions</td>
    <td><?php echosort('sortby', 'model', 'model'); ?></td>
    <td><?php echosort('sortby', 'workstart', 'start'); ?></td>
    <td><?php echosort('sortby', 'assignment', 'status'); ?></td>
    <td><?php echosort('sortby', 'clienttag', 'client'); ?></td>
    <td><?php echosort('sortby', 'pdone', '% done'); ?></td>
	 <td><?php echosort('sortby', 'timeon', 'hrs work'); ?></td>
	 <td>hrs assigned</td>
    <td><?php echosort('sortby', 'checkins', 'checkins'); ?></td>
  </tr>
  <?php $x = 0;
  do { 
  $x = $x + 1;?>
  <tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
  		<td> 
			<?php
				if ($row_rs_clients['assignment'] == 2) {
					echo "<a href='index.php?page=workchange";
					echo getqstring("page")."&changekey_workid=".$row_rs_clients['workid'];
					echo "&changekey_assignment=0"; 
					echo "&changekey_checkins=0";
					echo "&changekey_pdone=0";
					echo "&changekey_timeon=0";
					echo "&nextpage=work";
					echo "&message=released";
					echo "'>";
					echo "Release";
					echo "</a><br>";
				}
			
				if ($row_rs_clients['assignment'] == 1) {
					echo "<a href='index.php?page=workchange";
					echo getqstring("page")."&changekey_workid=".$row_rs_clients['workid'];
					echo "&changekey_assignment=0"; 
					echo "&changekey_checkins=0";
					echo "&changekey_pdone=0";
					echo "&changekey_timeon=0";
					echo "&nextpage=work";
					echo "&message=released";
					echo "'>";
					echo "Release";
					echo "</a><br>";
				}
				
				if ($row_rs_clients['assignment'] == -1) {
					echo "<a href='index.php?page=workchange";
					echo getqstring("page")."&changekey_workid=".$row_rs_clients['workid'];
					echo "&changekey_assignment=0"; 
					echo "&changekey_checkins=0";
					echo "&changekey_pdone=0";
					echo "&changekey_timeon=0";
					echo "&nextpage=work";
					echo "&message=redo";
					echo "'>";
					echo "Redo";
					echo "</a><br>";
				}
				
				if ($row_rs_clients['assignment'] > -1) {
					echo "<a href='index.php?page=workchange";
					echo getqstring("page")."&changekey_workid=".$row_rs_clients['workid'];
					echo "&changekey_assignment=-1"; 
					echo "&changekey_pdone=100";
					echo "&nextpage=work";
					echo "&message=Marked Done";
					echo "'>";
					echo "Mark Done";
					echo "</a><br>";
				}
				
				if (($row_rs_clients['clientid'] > 0) && empty($row_rs_clients['fclientid'])) {
					echo "<a href='index.php?page=workchange";
					echo getqstring("page")."&changekey_workid=".$row_rs_clients['workid'];
					echo "&changekey_assignment=0"; 
					echo "&changekey_checkins=0";
					echo "&changekey_clientid=0";
					echo "&changekey_pdone=0";
					echo "&changekey_timeon=0";
					echo "&nextpage=work";
					echo "&message=released";
					echo "'>";
					echo "<strong>Release</strong>";
					echo "</a><br>";
				}
			?>
		</td>
    <td> <?php echo $row_rs_clients['model']; ?>&nbsp;  </td>
    <td> <?php echo $row_rs_clients['workstart']; ?>&nbsp; </td>
    <td> <?php 
		if($row_rs_clients['assignment'] == -1) {
			echo "Finished"; 
			$timetocomplete = (strtotime($row_rs_clients['timefinished']) - strtotime($row_rs_clients['timestarted']));
			$timetocomplete = $timetocomplete / 3600;
		}
		
		if($row_rs_clients['assignment'] == 0) {
			echo "Queued" ;
			$timetocomplete = 0;
		} 
		
		if($row_rs_clients['assignment'] == 1) {
			echo "Working";
			$timetocomplete = (strtotime(date("Y/m/d H:i:s")) - strtotime($row_rs_clients['timestarted']));
			$timetocomplete = $timetocomplete / 3600;
			$timetocomplete = $timetocomplete + $row_rs_clients['lastseen'];
		}
		
		if($row_rs_clients['assignment'] == 2) {
			echo "Checked Out";
			$timetocomplete = (strtotime(date("Y/m/d H:i:s")) - strtotime($row_rs_clients['timestarted']));
			$timetocomplete = $timetocomplete / 3600;
		}
		
		if (($row_rs_clients['clientid'] > 0) && empty($row_rs_clients['fclientid'])) {
			echo "<strong>LIMBO</strong>" ;
			$timetocomplete = 0;
		} 
		

	 ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['clienttag']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['pdone']; ?>%&nbsp; </td>
    <td> <?php printf("%01.2f",($row_rs_clients['timeon']/3600)); ?>&nbsp; </td>
	<td><?php
		printf("%01.2f", $timetocomplete);
	?></td>
	<td> <?php echo $row_rs_clients['checkins']; ?>&nbsp; </td>
  </tr>
  <?php  } while ($row_rs_clients = mysql_fetch_assoc($rs_clients)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
	<tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
  <tr>
    <td width="23%" align="center">
      <?php if ($pageNum_rs_clients > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_rs_clients=%d%s", $currentPage, 0, $queryString_rs_clients); ?>">First</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center">
      <?php if ($pageNum_rs_clients > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_rs_clients=%d%s", $currentPage, max(0, $pageNum_rs_clients - 1), $queryString_rs_clients); ?>">Previous</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center">
      <?php if ($pageNum_rs_clients < $totalPages_rs_clients) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_rs_clients=%d%s", $currentPage, min($totalPages_rs_clients, $pageNum_rs_clients + 1), $queryString_rs_clients); ?>">Next</a>
      <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center">
      <?php if ($pageNum_rs_clients < $totalPages_rs_clients) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_rs_clients=%d%s", $currentPage, $totalPages_rs_clients, $queryString_rs_clients); ?>">Last</a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_rs_clients + 1) ?> to <?php echo min($startRow_rs_clients + $maxRows_rs_clients, $totalRows_rs_clients) ?> of <?php echo $totalRows_rs_clients ?>
</body>
</html>
<?php
mysql_free_result($rs_clients);
?>
