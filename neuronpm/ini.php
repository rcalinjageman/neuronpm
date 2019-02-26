<?php
# this file is an initialization for any admin page of nsweep
# the BASE and realpath are copied whole-cloth from exponent (http://exponentcms.org Copyright (c) 2004-2005 James Hunt and the OIC Group, Inc.)
# 
# this file should be included on each admin page
# Bob Calin-Jageman


# copied from eponentcms.org, used to determine base path of the installation
function __realpath($path) {
	$path = str_replace('\\','/',realpath($path));
	if ($path{1} == ':') {
		// We can't just check for C:/, because windows users may have the IIS webroot on X: or F:, etc.
		$path = substr($path,2);
	}
	return $path;
}

# defines base path of the installation
if (!defined('BASE')) {
	/*
	 * BASE Constant
	 *
	 * The BASE constant is the absolute path on the server filesystem, from the root (/ or C:\)
	 * to the Exponent directory.
	 */
	define('BASE',__realpath(dirname(__FILE__)).'/');
}

# need a configutation file to continue
if (!file_exists(BASE.'conf/config.php')) {
		exit('No configuration file found');
	}
	
# load the configuration file
include_once('conf/config.php');

# authenticate the administrator
if ($_SERVER['PHP_AUTH_USER'] != USER  || $_SERVER['PHP_AUTH_PW'] != PASS) {
		header('WWW-Authenticate: Basic Realm="Nsweep"');
		header('HTTP/1. 401 Unauthorized');
		print('Please login');
		exit;
	}	
	
?>
