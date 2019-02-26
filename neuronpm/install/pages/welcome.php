<?php
# this page starts the install process
#  
#
# Bob Calin-Jageman

# should start all sub pages to prevent outside access
if (!defined('BASE')) exit('');
?>
<h3>Setup NSweep... </h3>
<p>Welcome to NSweep. The system has detected that NSweep has not yet been configured on your server and will now walk you through the configuration process:</p>
<ol>
  <li><em>This welcome page (easy enough) </em></li>
  <li>Sanity check (make sure the server meets the requirements)</li>
  <li>Database configuation (tell NSweep how to connect to your MySQL server)</li>
  <li>Database setup (NSweep will create the MySQL tables and relationships it needs to run)</li>
  <li>Start using NSweep (setup models, sweeps, and approve clients) </li>
</ol>

<p>&nbsp;</p>
<p><em>NOTE: I wouldn't have been able to write this without extensive borrowing from <a href="http://www.exponentcms.org">Exponent</a> (Copyright (c) 2004-2005 James Hunt and the OIC Group, Inc.), a terrific PHP/MySQL content-management system renowed for its ease of install.. </em><br> 
</p>
