<?php
# this file checks the dbconnection and then adds the NSweep tables
# the connection tests are copied whole-cloth from exponent (http://exponentcms.org Copyright (c) 2004-2005 James Hunt and the OIC Group, Inc.)
#  and rely on the mysql class created in exponent
# 
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');

# load the class for the database connections
include_once(BASE.'Connections/database.php');

?>


<h3 id="subtitle">DbSetup...</h3>
<table>
<tr><td valign="top" class="bodytext"><div style="background-color: lightgrey;">Checking Connection:</div></td></tr>
<?php

# each of these functions are copied direct from exponent
function echoStart($msg) {
	echo '<tr><td valign="top" class="bodytext">'.$msg.'</td><td valign="top" class="bodytext">';
}

function echoSuccess($msg = "") {
	echo '<span class="success">Succeeded</span>';
	if ($msg != "") echo " : $msg";
	echo '</td></tr>';
}

function echoFailure($msg = "") {
	echo '<span class="failed">Failed</span>';
	if ($msg != "") echo " : $msg";
	echo '</td></tr>';
}

function isAllGood($str) {
	return !preg_match("/[^A-Za-z0-9]/",$str);
}

$passed = true;

if ($passed) {
	# modified this for nsweep
	$db = pathos_database_connect(DB_USER,DB_PASS,DB_HOST,DB_NAME,"mysql",1);
	$db->prefix = "nsweep_";
	
	$status = array();
	
	echoStart("Connecting:");

	if ($db->connection == null) {
		echoFailure($db->error());
		// BETTER ERROR CHECKING
		$passed = false;
	}
}

if ($passed) {
	$tables = $db->getTables();
	if ($db->inError()) {
		echoFailure($db->error());
		$passed = false;
	} else {
		echoSuccess();
	}
}

$tablename = "installer_test".time(); // Used for other things

$dd = array(
	"id"=>array(
		DB_FIELD_TYPE=>DB_DEF_ID,
		DB_PRIMARY=>true,
		DB_INCREMENT=>true),
	"installer_test"=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>100)
);

if ($passed) {
	$db->createTable($tablename,$dd,array());
	
	echoStart("Checking CREATE TABLE privilege:");
	if ($db->tableExists($tablename)) {
		echoSuccess();
	} else {
		echoFailure();
		$passed = false;
	}
}

$insert_id = null;
$obj = null;

if ($passed) {
	echoStart("Checking INSERT privilege:");
	$obj->installer_test = "Exponent Installer Wizard";
	$insert_id = $db->insertObject($obj,$tablename);
	if ($insert_id == 0) {
		$passed = false;
		echoFailure($db->error());
	} else {
		echoSuccess();
	}
}

if ($passed) {
	echoStart("Checking SELECT privilege:");
	$obj = $db->selectObject($tablename,"id=".$insert_id);
	if ($obj == null || $obj->installer_test != "Exponent Installer Wizard") {
		$passed = false;
		echoFailure($db->error());
	} else {
		echoSuccess();
	}
}

if ($passed) {
	echoStart("Checking UPDATE privilege:");
	$obj->installer_test = "Exponent 2";
	if (!$db->updateObject($obj,$tablename)) {
		$passed = false;
		echoFailure($db->error());
	} else {
		echoSuccess();
	}
}

if ($passed) {
	echoStart("Checking DELETE privilege:");
	$db->delete($tablename,"id=".$insert_id);
	$error = $db->error();
	$obj = $db->selectObject($tablename,"id=".$insert_id);
	if ($obj != null) {
		$passed = false;
		echoFailure($error);
	} else {
		echoSuccess();
	}
}

if ($passed) {
	$dd["exponent"] = array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>8);
	
	echoStart("Checking ALTER TABLE privilege:");
	$db->alterTable($tablename,$dd,array());
	$error = $db->error();
	
	$obj = null;
	$obj->installer_test = "Exponent Installer ALTER test";
	$obj->exponent = "Exponent";
	
	if (!$db->insertObject($obj,$tablename)) {
		$passed = false;
		echoFailure($error);
	} else {
		echoSuccess();
	}
}


if ($passed) {
	echoStart("Checking DROP TABLE privilege:");
	$db->dropTable($tablename);
	$error = $db->error();
	if ($db->tableExists($tablename)) {
		$passed = false;
		echoFailure($error);
	} else {
		echoSuccess();
	}
}

# my own function!!
# this function reads a php file containing a series of mysql commands; it parses it at the semi-colons and executes the commands
# currently, no comments are allowed in the sql commands
if ($passed) {
	echoStart('<div style="background-color: lightgrey;">Installing Tables:</div>');
	
	$dir = BASE."install/sql";
	if (is_readable($dir)) {
		$dh = opendir($dir);
		while (($file = readdir($dh)) !== false) {
			if (is_readable("$dir/$file") && is_file("$dir/$file") && substr($file,-4,4) == ".php" && substr($file,-9,9) != ".info.php") {
	
				$dd = include($dir."/".$file);
				
				$sqlstatements = explode(";", $dd);
				for ($x = 0; $x < sizeof($sqlstatements); $x++) {
					if (isset($sqlstatements[$x]) && strlen(trim($sqlstatements[$x])) >0) {
						echoStart("sql statement: ".$x);
						$result = mysql_query($sqlstatements[$x], $db->connection); 
						if ($result == 1) {
							echoSuccess();
						} else {
							echoFailure($result);
						}
					}
				}	
				
			}
		}
	}
}



?>
</table>
<p>If all the steps listed above show success, <em>you are ready to run NSweep</em><br>
<strong>For security, you should delete this install directory when you are sure NSweep is running properly.</strong></p>
</body>
