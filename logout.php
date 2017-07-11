<?php 
session_start();
if (!isset($_SESSION['moic-portal.gov.np']))
{
  echo '<meta http-equiv="refresh" content="0;URL='.$URL.'login.html" />';	
}
$isLogout = true;

$_SESSION['editmode'] = "yes";

	$username = $_SESSION['user']['name'];

	$_SESSION['logout'] = true;
	$authorized = false;

	destroy_session($db);

	echo "<div style=\"margin-top:15%;\"><center /><h2><strong>Logging out...</strong><h2></div>";
?>
  <form id="formlogout" action='<?php echo $URL;?>login.html' METHOD='POST'>
    <input type='hidden' name='logout' value='true'>
  </form>
	<script>
	window.setTimeout(function() {
		$("#formlogout").submit();
		return false; //Prevent the browser jump to the link anchor
	}, 700); 
  </script>
