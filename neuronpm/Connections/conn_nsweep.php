<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_nsweep = DB_HOST;
$database_conn_nsweep = DB_NAME;
$username_conn_nsweep = DB_USER;
$password_conn_nsweep = DB_PASS;
$conn_nsweep = mysql_pconnect($hostname_conn_nsweep, $username_conn_nsweep, $password_conn_nsweep) or trigger_error(mysql_error(),E_USER_ERROR); 
?>