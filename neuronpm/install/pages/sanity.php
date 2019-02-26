<?php 
# this is the sanity-check for NSweep
# It was hacked together from exponent (http://exponentcms.org Copyright (c) 2004-2005 James Hunt and the OIC Group, Inc.)
# 
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');

# direct from eponents
define('SANITY_FINE',				0);
define('SANITY_NOT_R',				2);
define('SANITY_NOT_RW',				4);
define('SANITY_NOT_E',				8);

define('SANITY_READONLY',			1);
define('SANITY_READWRITE',			2);
define('SANITY_CREATEFILE',			4);

define('SANITY_WARNING',			1);
define('SANITY_ERROR',				2);

# checks php version, from exponent
function _sanity_checkPHPVersion() {
	if (version_compare(phpversion(),'4.0.6','>=')) {
		return array(SANITY_FINE,phpversion());
	} else {
		return array(SANITY_ERROR,'PHP < 4.0.6 (not supported)');
	}
}

# checks that the temp directory required for uploads is available, straight from exponent
function _sanity_checkTemp($dir) {
	$file = tempnam($dir,'temp');
	if (is_readable($file) && is_writable($file)) {
		unlink($file);
		return array(SANITY_FINE,'Passed');
	} else {
		return array(SANITY_ERROR,'Failed');
	}
}

# runs list of checks required for server, modified from exponent
function sanity_checkServer() {
	$status = array(
		'PHP 4.0.6+'=>_sanity_checkPHPVersion(),
		'File Uploads Enabled'=>_sanity_checkTemp(ini_get('upload_tmp_dir')),
	);
	return $status;
}

# function to see if file has necessary properties, straight from exponent
function sanity_checkFile($file,$as_file,$flags) {
	$__oldumask = umask(0);
	if (!file_exists($file)) {
		if ($flags == SANITY_CREATEFILE) {
			return sanity_checkFile(dirname($file),false,SANITY_READWRITE);
		} else {
			if ($as_file) {
				@touch($file);
			} else {
				@mkdir($file,0777);
			}
		}
	}
	if (!file_exists($file)) {
		umask($__oldumask);
		return SANITY_NOT_E;
	} else if ($flags == SANITY_CREATEFILE) {
		$flags = SANITY_READWRITE;
	}
	$not_r = false;
	// File exists.  Check the flags for what to check for
	if ($flags == SANITY_READONLY || $flags == SANITY_READWRITE) {
		if (!is_readable($file)) {
			@chmod($file,0777);
		}
		if (!is_readable($file)) {
			if ($flags == SANITY_READONLY) {
				umask($__oldumask);
				return SANITY_NOT_R;
			}
			// Otherwise, we need to set NOT_R
			$not_r = true;
		}
	}
	if ($flags == SANITY_READWRITE) {
		if (!is_writable($file)) {
			@chmod($file,0777);
		}
		if (!is_writable($file)) {
			umask($__oldumask);
			return SANITY_NOT_RW;
		} else if ($not_r) {
			umask($__oldumask);
			return SANITY_NOT_R;
		}
	}
	return SANITY_FINE;
}

# checks to see if directory has required properties, straight from exponent
function sanity_checkDirectory($dir,$flag) {
	$status = sanity_checkFile(BASE.$dir,0,$flag);
	if ($status != SANITY_FINE) {
		return $status;
	}

	if (is_readable(BASE.$dir)) {
		$dh = opendir(BASE.$dir);
		while (($file = readdir($dh)) !== false) {
			if ($file{0} != '.' && $file != 'CVS') {
				if (is_file(BASE.$dir.'/'.$file)) {
					$status = sanity_checkFile(BASE.$dir.'/'.$file,1,$flag);
					if ($status != SANITY_FINE) {
						return $status;
					}
				} else {
					$status = sanity_checkDirectory($dir.'/'.$file,$flag);
					if ($status != SANITY_FINE) {
						return $status;
					}
				}
			}
		}
	}
}

# runs checks on file system, modified from exponent
function sanity_checkFiles() {
	$status = array(
		'conf/'=>sanity_checkDirectory('../conf', SANITY_READWRITE),
		'models/'=>sanity_checkDirectory('../models',SANITY_READWRITE)
        );

	return $status;
}


$status = sanity_checkFiles();

$errcount = count($status);
$warncount = 0;

?>

<h3 id="subtitle">
Sanity-check...</h3>
<p>Current minimum systen requirements:</p>
<p>1) Writable access to &quot;conf&quot; and &quot;models&quot; subdirectories </p>
<p>2) PHP &gt; 4.0.6 </p>
<p>3) Upload capability (rec to allow rather large uploads to accomodate potentially large data sets) </p>
<table cellspacing="0" cellpadding="3" rules="all" border="0" style="border:1px solid grey;" width="100%">
<tr><td colspan="2" style="background-color: lightgrey;"><b>File and Directory Permission Tests</b></td></tr>
<?php
# builds a table showing file check results, straight from exponent
foreach ($status as $file=>$stat) {
	echo '<tr><td width="55%" class="bodytext">'.$file.'</td><td align="center" width="45%"';
	if ($stat != SANITY_FINE) echo ' class="bodytext error">';
	else echo ' class="bodytext success">';
	switch ($stat) {
		case SANITY_NOT_E:
			echo 'File Not Found';
			break;
		case SANITY_NOT_R:
			echo 'Not Readable';
			break;
		case SANITY_NOT_RW:
			echo 'Not Readable / Writable';
			break;
		case SANITY_FINE:
			$errcount--;
			echo 'Okay';
			break;
		default:
			echo '????';
			break;
	}
	echo '</td></tr>';
}
?>
<tr><td colspan="2" style="background-color: lightgrey;"><b>Other Tests</b></td></tr>


<?php
# builds a table for server checks, straight from exponent
$status = sanity_checkServer();
$errcount += count($status);
$warncount += count($status);
foreach ($status as $test=>$stat) {
	echo '<tr><td width="55%" class="bodytext">'.$test.'</td>';
	echo '<td align="center" width="45%" ';
	if ($stat[0] == SANITY_FINE) {
		$warncount--;
		$errcount--;
		echo 'class="bodytext success">';
	} else if ($stat[0] == SANITY_ERROR) {
		$warncount--;
		echo 'class="bodytext error">';
	} else {
		$errcount--;
		echo 'class="bodytext warning">';
	}
	echo $stat[1].'</td></tr>';
}
?>
</table>
</div>
<br>

<?php
# reports total error count from server and file checks; mod from exponent
if ($errcount > 0 || $warncount > 0) {
	// Had errors.  Force halt and fix.
	echo 'Problems were found with the server environment, which you must fix before you can continue.';
} else {
	// No errors, and no warnings.  Let them through.
	echo 'No problems with the server environment.';
	}
	?>
