<?php
# this is the main page for NSweep Admin
#  
#
# Bob Calin-Jageman

# should start all admin pages
require('../ini.php');

# if a page hasn't been set, show the welcome page
if (!isset($_REQUEST['page'])) {
	$cpage = 'status';
} else {
	$cpage = $_REQUEST['page'];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo "Admin: ".$cpage; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../style.css" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  	<tr> 
		<td colspan="3" class="pos1" height="55" valign="middle"> 
			<div class="topbox">
			<h2>NeuronPM Admin</h2>
			</div>
		</td>
	</tr>

	<tr> 
		<td>
		   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="topnav">
	    		<tr> 
					<td align="left" class="head">
						Currently: <?php echo $cpage; ?>
					</td>
  
		    	  <td align="right">
				  		logged in as: <?php echo USER; ?> 
				  </td>
				</tr>
			</table>
	
			<table width="100%" border="0" cellpadding="0" cellspacing="0">

				<tr>
					<td valign="top" width="150"> 
					<br /><div>
						<div class="headbox">Create</div>
							<a class="leftmenu" href="index.php?page=models" title="models">Models</a>
							<a class="leftmenu" href="index.php?page=parameters" title="parameters">Parameters</a>
							<a class="leftmenu" href="index.php?page=init" title="init">Init</a>
					<br>
						<div class="headbox">Monitor</div>
							<a class="leftmenu" href="index.php?page=clients" title="clients_working">Clients</a>
							<a class="leftmenu" href="index.php?page=work" title="work">Work</a>
							<a class="leftmenu" href="index.php?page=status" title="status">Status</a>

					<br>
						<div class="headbox">Settings</div>
							<a class="leftmenu" href="../install/" title="install">Install</a>
							<a class="leftmenu" href="index.php?page=password" title="password">Password</a>
							<a class="leftmenu" href="index.php?page=settings" title="settings">settings</a>
				
						<div class="dynacontent">
			  	  			<p>Problems or bugs?  Please <a href="mailto:rcalinjageman@gsu.edu">email</a> Bob.</p>       
						</div>	
	
					</td>

					<td valign="top"> <br />
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr> 
								<td width="10"></td>

	        					<td valign="top" class="dynacontent"> 
									<?php 	include_once(BASE."admin/".$cpage.".php");?>
		    					</td>
					
    	    				</tr>
    		 		  </table>
		 			<br />
         			</td>

      				</tr>
 			</table>
    	</td>
  	</tr>	

  	<tr class="pos1"> 
    	<td height="20" colspan="2" class="head" align="right">&copy; 2005 Lab of Paul S. Katz - Georgia State University &nbsp;</td>
	</tr>
</table>
</body>
</html>
