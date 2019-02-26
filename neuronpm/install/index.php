<?php
# this is the install main page for NSweep
#  
#
# Bob Calin-Jageman

# should start all admin pages
require('../ini.php');

# if a page hasn't been set, show the welcome paghe
if (!isset($_REQUEST['page'])) {
	$cpage = 'welcome';
} else {
	$cpage = $_REQUEST['page'];
}

# used to control menu display and next link
$highlighting = array('welcome' => "", "sanity" => "", "dbsetup" => "", "dbconfig" => "");
$next = array('welcome' => "sanity", "sanity" => "dbconfig", "dbconfig" => "dbsetup");
$highlighting[$cpage] = "<b>"
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo "Install: ".$cpage; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../style.css" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr> 
    <td colspan="3" class="pos1" height="55" valign="middle"> 
      <div class="topbox">
        <h2>NeuronPM Install</h2>
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

 <table width="100%"  border="1">
     <td width="17%" valign="top">
	 <div class="headbox">Install Steps:</div>
      
        <span class="pos0"><?php echo $highlighting["welcome"]; ?>1.  Welcome</b></span><br>
         <span class="pos0"><?php echo $highlighting["sanity"]; ?>2. Sanity</b></span><br>
         <span class="pos0"><?php echo $highlighting["dbconfig"]; ?>3. DB Config</b></span><br>
         <span class="pos0"><?php echo $highlighting["dbsetup"]; ?>4. DB setup</b></span><br>
     </td>
     <td width="83%">
<?php 
	include_once(BASE."install/pages/".$cpage.".php");
?>
     </td>
   </tr>
 </table>
 <?php
if ($cpage=="dbsetup") {
 	echo '<p>If this page completed correctly, NSweep is setup and you can begin working with it <a href="../admin">here</a></p>';
} else {
	echo '<p>If all went well, move to the next <a href="index.php?page='.$next[$cpage].'">step</a>.</p>';
}
?><br>
Or back to <a href="../admin">admin</a>.
</body>
</html>
