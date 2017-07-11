<?php
include_once "permission.config.inc.php";
if (isset($_SESSION['moic-portal.gov.np']))
{
		$now = time(); // Checking the time now when home page starts.
		if ($now > $_SESSION['expire'])
		{
			destroy_session($db);
			notify("Session Expire","Your session has been expired!", $URL."login.html",true,5000);
			exit();
			$_SESSION['exp'] = TRUE;
		}
		else
		{
			$_SESSION['expire'] = time() + $session_time ;
			$_SESSION['exp'] = FALSE;
		}
		$previouspage = $_SERVER['HTTP_REFERER'];
		if (!($Permission & $UserRight))
		{
			notify("User Permission","You don't have necessary permission to access this page.<br><br>Please contact your Administrator.", $previouspage,TRUE, 5000);
			exit();	
		} 
}
else
{
	echo '<meta http-equiv="refresh" content="0;URL='.$URL.'login.html" />';	
}
?>