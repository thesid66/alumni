<?php 
error_reporting(0);
session_start();
define ("ALUMNI","TRUE");
define ("OWNER","IT EXPERT");
define ("ADDRESS","SUKEDHARA");
define ("HEADER","header.inc.php");

include_once "header.inc.php";

global $noPermission;
global $URL;

$now = time(); // Checking the time now when home page starts.

if ($DisplayMenu)
{
	if ($now > $_SESSION['expire'])
	{
		destroy_session($db);
		notify("Session Expire","Your session has been expired!", $URL."login.html",true,5000);
		include_once "footer.inc.php";
		$_SESSION['exp'] = TRUE;
		exit();
	}
	else
	{
		$_SESSION['expire'] = time() + $session_time ;
		$_SESSION['exp'] = FALSE;
		update_session($db);
	}
}
if ($noSession)
{
	notify("No Session","<font color=red>There is no any registered Session.</font>",$URL . "logout.html");
}
else if ($noPermission)
{
	notify("User Previlege","<font color=red>You don't have permission to access this page <br><br>If you think this is an error, contact to System Administrator </font>",$URL . "dashboard.html",TRUE,5000);
		include_once "footer.inc.php";
		exit();
}
else
{
	include_once $page;
}
	include_once "foot.php";
	include_once "footer.inc.php";
?>