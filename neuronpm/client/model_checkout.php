<?php 
# this page allows a client to check out an object
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
require_once("../client_ini.php");
if (!defined('BASE')) exit('');
require_once("../Connections/conn_nsweep.php");

function read_dir($path){
   $handle=opendir($path);
   while ($file = readdir($handle)) {           
         if ($file != "." && $file != "..") {                             
		   	if (is_dir($path.$file)) {
				$relpath = str_replace(BASE, "", $path);
		   		echo ('<nsweep>'.$relpath . $file . '/=dir</nsweep><br>');
				read_dir($path . $file . "/" );          
		   	} else {
				$relpath = str_replace(BASE, "", $path);
		    	echo ('<nsweep>'.$relpath . $file.'=file</nsweep><br>');
		   	}
       }      
   }
   
}

	if (isset($_REQUEST['model'])) {
		mysql_select_db($database_conn_nsweep, $conn_nsweep);
		$query_rs_models = "SELECT * FROM nsweep_models WHERE active = 1";
		$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
		$row_rs_active = mysql_fetch_assoc($rs_active);
	
		if (mysql_num_rows($rs_active) != 1) { 
			mysql_free_result($rs_active);
			exit(timeout("1200")."<nsweep>nowork=no model published</nsweep>");
		}
	
		if ($row_rs_active['model'] != $_REQUEST['model']) { 
			mysql_free_result($rs_active);
			exit(timeout("1200")."<nsweep>nowork=wrong model requested</nsweep>");
		}

	 echo "<nsweep>/models/".$_REQUEST['model']."/params.hoc=file</nsweep>";
	 echo "<nsweep>model=".$_REQUEST['model']."</nsweep>";
	 echo "<nsweep>modelversion=".$row_rs_active['version']."</nsweep>";
	 echo "<nsweep>modelstart=".$row_rs_active['startfile']."</nsweep>";
	 echo "<nsweep>inlinereport=".$row_rs_active['inlinereport']."</nsweep>";
	 
	 mysql_select_db($database_conn_nsweep, $conn_nsweep);
		$query_rs_models = "SELECT * FROM nsweep_params WHERE model = '".$_REQUEST['model']."'";
		$rs_active = mysql_query($query_rs_models, $conn_nsweep) or die("**: Can't connect to the database.  You need to run the <a href='../install'>install</a> routings for NSweep<br>");
		$row_rs_active = mysql_fetch_assoc($rs_active);
	 	echo "<nsweep>modelparams=".mysql_num_rows($rs_active)."</nsweep>";
		mysql_free_result($rs_active);
		
     $modeldir = BASE."/models/".$_REQUEST['model'];
	 echo $modeldir;
	 read_dir($modeldir.'/simfiles/'); 
	 echo "<nsweep>command=success</nsweep>";

	}
?>