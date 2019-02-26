<?php
# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');

function readconf() {
		$confsettings['DB_HOST'] = DB_HOST;
		$confsettings['DB_PORT'] = DB_PORT;
		$confsettings['DB_NAME'] = DB_NAME;
		$confsettings['DB_USER'] = DB_USER;
		$confsettings['DB_PASS'] = DB_PASS;
		$confsettings['USER'] = USER;
		$confsettings['PASS'] = PASS;
		$confsettings['APPROVEDONLY'] = APPROVEDONLY;
		$confsettings['CLIENTPASS'] = CLIENTPASS;
		return $confsettings;
}

function writeconf($confsettings) {
		
		$confile = fopen(BASE."conf/config.php", "w");
		$keyvalue = "define(".chr(34)."%s".chr(34).", '%s');\n";
		fwrite($confile, "<?php\n");

		reset($confsettings);
		for($x = 0; $x < sizeof($confsettings); $x++) {
			$output = sprintf($keyvalue, key($confsettings), $confsettings[key($confsettings)]);

			fwrite($confile, $output);
			next($confsettings);
		}

		fwrite($confile, "?>");
		fclose($confile);
}
?>