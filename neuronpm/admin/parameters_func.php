<?php 
# this page has some reusable functions for parameters
# it is a first step to establishing classes for the objects in NSweep and making the server
#   portion cleaner and easier to maintain
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
require_once('../Connections/conn_nsweep.php');

function param_vallist($type, $ubound, $p1, $p2, $list) {
	if ($type == "list") {
		return $list;
	}
	$vallist = "";
	for ($x = 0; $x < $ubound; $x++) {
		if ($type == "line") {
			$vallist.= ($x * $p1) + $p2.", ";
		} else {
			$vallist.= (pow($p1,($x+$p2))).", ";
		}
	}
	return $vallist;
}

function param_setline($setline, $operator, $pname, $pnumber) {	
	switch($operator) {
		case "=":
			$aline = "temp_".$pnumber." = ".$setline." \n	". $setline." = ".$pname;
			return $aline;
		case "*":
			$aline = "temp_".$pnumber." = ".$setline." \n	". $setline." = ".$setline." * ".$pname;
			return $aline;
		case "+":
			$aline = "temp_".$pnumber." = ".$setline." \n	". $setline." = ".$setline." + ".$pname;
			return $aline;
	}
		return $aline;
}


function param_assignline($setline, $operator, $pname, $pnumber) {	
	switch($operator) {
		case "=":
			$aline = $setline." = ".$pname;
			return $aline;
		case "*":
			$aline = $setline." = ".$setline." * ".$pname;
			return $aline;
		case "+":
			$aline = $setline." = ".$setline." + ".$pname;
			return $aline;
	}
		return $aline;
}

function param_revertline($setline, $operator, $pname, $pnumber) {	
			$aline = $setline." = "."temp_".$pnumber;
			return $aline;
		return $aline;
}

function param_char($model, $dbconn, $conn) {
	mysql_select_db($dbconn, $conn);
	$query_rs_parameters = sprintf("SELECT ubound, model FROM nsweep_params WHERE model = '%s'", $model);
	$rs_parameters = mysql_query($query_rs_parameters, $conn) or die(mysql_error());
	$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	
	$numruns = 1;
	do { 
  		$numruns = $numruns * ($row_rs_parameters['ubound']);
	} while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters));
	$results = array("pcount"=>mysql_num_rows($rs_parameters), "runsneeded"=>$numruns);
	mysql_free_result($rs_parameters);
	return $results;
}

function param_write_params($model, $dbconn, $conn) {
	# open params.hoc
	$filename = BASE."/models/".$model."/params.hoc";
	# if (file_exists($filename)) { return "  Params.hoc already existed"; break; }
	if (!($pfile = fopen($filename, "w"))) { return "  Couldn't create params.hoc"; }
	
	#get the parameters for this model
	mysql_select_db($dbconn, $conn);
	$query_rs_parameters = sprintf("SELECT * FROM nsweep_params WHERE model = '%s'", $model);
	$rs_parameters = mysql_query($query_rs_parameters, $conn) or die(mysql_error());
	$row_rs_parameters = mysql_fetch_assoc($rs_parameters);
	
	#write the parameter object
	fwrite($pfile, "/* Created by NeuronPM */ \n");
	fwrite($pfile, "objref param[".mysql_num_rows($rs_parameters)."] \n");

	
	#write the paraminit function
	fwrite($pfile, "proc paraminit() {localobj neuronpmvec \n");
	$x = 0;	
	do { 
		if ($row_rs_parameters['type'] == 'list') {
			fwrite($pfile, "   neuronpmvec = new Vector() \n");
			$line = sprintf('   neuronpmvec.append(%s)', $row_rs_parameters['list']);
			fwrite($pfile, $line."\n");
			$line = sprintf('   param[%s] = new Parameter("%s", "%s", neuronpmvec)', $x, $row_rs_parameters['name'], $row_rs_parameters['type']);
		} else {
			$line = sprintf('	param[%s] =  new Parameter("%s", "%s", %s, %s, %s)', $x, $row_rs_parameters['name'], $row_rs_parameters['type'], $row_rs_parameters['ubound'] - 1, $row_rs_parameters['p1'], $row_rs_parameters['p2']);
		}
		fwrite($pfile, $line."\n \n");
		$x++;
	} while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters));
	fwrite($pfile, "} \n \n");
	
	#write the paramset function
	mysql_data_seek($rs_parameters, 0);
	fwrite($pfile, "proc paramset() {\n");
	$x = 0;
	while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters)) {
		$towrite = "	".param_setline($row_rs_parameters['setline'], $row_rs_parameters['setoperator'], "plist.object(".$x.").value", $x)."\n";
		echo $towrite."<br>";
		fwrite($pfile, $towrite);
		$x++;	
	}
	fwrite($pfile, "} \n \n");
	echo "got this far";
	
	#write the paramrevert function
	mysql_data_seek($rs_parameters, 0);
	fwrite($pfile, "proc paramrevert() {\n");
	$x = 0;
	while ($row_rs_parameters = mysql_fetch_assoc($rs_parameters)) {
		fwrite($pfile, "	".param_revertline($row_rs_parameters['setline'], $row_rs_parameters['setoperator'], "plist.object(".$x.").value", $x)."\n");
		$x++;	
	}
	fwrite($pfile, "} \n \n");

	#write the paramsummary function
	$query_rs_parameters = sprintf("SELECT reportline, model FROM nsweep_models WHERE model = '%s'", $model);
	$rs_models = mysql_query($query_rs_parameters, $conn) or die(mysql_error());
	$row_rs_models = mysql_fetch_assoc($rs_models);
	
	fwrite($pfile, "proc paramsummary() {\n");
	fwrite($pfile, "	".$row_rs_models['reportline']."\n");
	fwrite($pfile, "}");
	
	#cleanup
	fclose($pfile);
	mysql_free_result($rs_parameters);
	mysql_free_result($rs_models);
	return " param.hoc created";
}
?>