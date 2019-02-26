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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_clients = 100;
$pageNum_rs_clients = 0;
if (isset($_GET['pageNum_rs_clients'])) {
  $pageNum_rs_clients = $_GET['pageNum_rs_clients'];
}
$startRow_rs_clients = $pageNum_rs_clients * $maxRows_rs_clients;

$sortby = "approved";
if (isset($_REQUEST['sortby'])) { $sortby = $_REQUEST['sortby']; }

$approved = "0";
if (isset($_REQUEST['form_approved'])) {$approved = $_REQUEST['form_approved']; }

$status = "-99";
if (isset($_REQUEST['form_status'])) { $status = $_REQUEST['form_status']; }

mysql_select_db($database_conn_nsweep, $conn_nsweep);
$query_rs_clients = "SELECT * FROM nsweep_clients WHERE";
if ($approved == -99) {
	$query_rs_clients.= "(`approved` <> -99)";
} else {
	$query_rs_clients.=" (`approved` = ".$approved.")";
}

if ($status == -99) {
	$query_rs_clients.= "AND (`status` <> -99) ";
} else {
	$query_rs_clients.= "AND (`status` = ".$status.") ";
}

$query_rs_clients.= "ORDER BY ".$sortby.", approved ASC";

$query_limit_rs_clients = sprintf("%s LIMIT %d, %d", $query_rs_clients, $startRow_rs_clients, $maxRows_rs_clients);
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
  status: 
  <select name="form_status" id="form_status">
    <option value="-99" <?php if ($status == -99) { echo "selected"; }?>>all</option>
    <option value="1" <?php if ($status == 1) { echo "selected"; }?>>working</option>
    <option value="0" <?php if ($status == 0) { echo "selected"; }?>>offline</option>
  </select> 
  approved:
  <select name="form_approved" id="form_approved">
    <option value="-99" <?php if ($approved == -99) { echo "selected"; }?>>all</option>
    <option value="1" <?php if ($approved == 1) { echo "selected"; }?>>approved</option>
    <option value="0" <?php if ($approved == 0) { echo "selected"; }?>>unapproved</option>
    <option value="-1" <?php if ($approved == -1) { echo "selected"; }?>>banned</option>
  </select>
  <input type="submit" name="Submit" value="Go">
  <input type="hidden" name="page" value = "clients">
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
    <td><?php echosort('sortby', 'ip', 'ip'); ?></td>
    <td><?php echosort('sortby', 'host', 'host'); ?></td>
    <td><?php echosort('sortby', 'status', 'status'); ?></td>
    <td><?php echosort('sortby', 'approved', 'appr'); ?></td>
	<td><?php echosort('sortby', 'model', 'model'); ?></td>
    <td><?php echosort('sortby', 'modelversion', 'mvers'); ?></td>
    <td><?php echosort('sortby', 'clientversion', 'cvers'); ?></td>
    <td><?php echosort('sortby', 'cblock', 'wblock'); ?></td>
    <td><?php echosort('sortby', 'lastcomm', 'last seen'); ?></td>
	<td><?php echosort('sortby', 'lastreply', 'last reply'); ?></td>
    <td><?php echosort('sortby', 'cameon', 'checkins'); ?></td>
    <td><?php echosort('sortby', 'timeon', 'idle hrs'); ?></td>
    <td><?php echosort('sortby', 'blockscomplete', 'completed blocks'); ?></td>
	<td>hrs/block</td>
	<td>% idle</td>
	<td>hrs/idle</td>
  </tr>
  <?php $x = 0;
  do { 
  $x = $x + 1;?>
  <tr align="right" valign="bottom" class="pos<?php echo ($x%2); ?>">
  		<td> 
			<?php
				if ($row_rs_clients['status'] == 1) {
					echo "<a href='index.php?page=clientchange";
					echo getqstring("page")."&changekey_clientid=".$row_rs_clients['clientid'];
					echo "&changekey_status=0"; 
					echo "&nextpage=clients";
					echo "&message=released";
					echo "'>";
					echo "Release";
					echo "</a><br>";
				}
				
				if ($row_rs_clients['approved'] == -1) {
					echo "<a href='index.php?page=clientchange";
					echo getqstring("page")."&changekey_clientid=".$row_rs_clients['clientid'];
					echo "&changekey_approved=1"; 
					echo "&nextpage=clients";
					echo "&message=unbanned";
					echo "'>";
					echo "Un-Ban";
					echo "</a><br>";
				}
				
				if ($row_rs_clients['approved'] > -1) {
					echo "<a href='index.php?page=clientchange";
					echo getqstring("page")."&changekey_clientid=".$row_rs_clients['clientid'];
					echo "&changekey_approved=-1"; 
					echo "&message=banned";
					echo "&nextpage=clients";
					echo "'>";
					echo "Ban";
					echo "</a><br>";
				}
				
				if ($row_rs_clients['approved'] == 0) {
					echo "<a href='index.php?page=clientchange";
					echo getqstring("page")."&changekey_clientid=".$row_rs_clients['clientid'];
					echo "&changekey_approved=1"; 
					echo "&nextpage=clients";
					echo "&message=approved";
					echo "'>";
					echo "Approve";
					echo "</a><br>";
				}
				
				echo "<a href='index.php?page=client_del&clientid=".$row_rs_clients['clientid']."&MM_del=true'>delete</a><br>";
			?>
		</td>
    <td> <?php echo $row_rs_clients['ip']; ?>&nbsp;  </td>
    <td> <?php echo $row_rs_clients['host']; ?>&nbsp; </td>
    <td> <?php if($row_rs_clients['status'] == 0) {echo "offline"; } else {echo "working"; } ?>&nbsp; </td>
    <td> <?php if($row_rs_clients['approved'] == -1) {
		echo "banned"; 
	} else {
		if($row_rs_clients['approved'] == 0) {
			echo "unknown" ;
		} else {
			echo "approved";
		}
	}
	; ?>&nbsp; </td>
	 <td> <?php echo $row_rs_clients['model']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['modelversion']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['clientversion']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['cblock']; ?>&nbsp; </td>
	
    <td> <?php 
			$lastseen = (strtotime(date("Y/m/d H:i:s")) - strtotime($row_rs_clients['lastcomm']));
			$lastseen = $lastseen / 3600;
			printf("%01.2f", $lastseen); ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['lastreply']; ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['cameon']; ?>&nbsp; </td>
    <td> <?php 
			$idletime = $row_rs_clients['timeon']/3600;
			if ($row_rs_clients['status'] == 1) {
				$idletime = $idletime + $lastseen;
			}
	printf("%01.2f", $idletime); ?>&nbsp; </td>
    <td> <?php echo $row_rs_clients['blockscomplete']; ?>&nbsp; </td>
    <td> <?php
		if ($row_rs_clients['blockscomplete'] != 0) {
				$hoursperblock = $row_rs_clients['timeon'] / (3600 * $row_rs_clients['blockscomplete']);
					printf("%01.2f", $hoursperblock);
		}
	?>
	</td>
	<td> <?php
		if ($row_rs_clients['started'] != 0) {
			$sincestart = (strtotime(date("Y/m/d H:i:s")) - strtotime($row_rs_clients['started']));
			$sincestart = $sincestart / 3600;
			$pidle = ($idletime / $sincestart) * 100;
			printf("%01.2f", $pidle);
		}
	?>%
	</td>
	<td> <?php
		if ($row_rs_clients['cameon'] !=0) {
			$hoursperidle = $idletime / ($row_rs_clients['cameon'] + $row_rs_clients['status']);
		}
		printf("%01.2f", $hoursperidle);
	?></td>
  </tr>
  <?php } while ($row_rs_clients = mysql_fetch_assoc($rs_clients)); ?>
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
