<?php
error_reporting(0);
session_start();
define ("ALUMNI","TRUE");
define ("OWNER","IT EXPERT");
define ("ADDRESS","SUKEDHARA");
define ("HEADER","header.inc.php");

header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 1 Jan 2000 00:00:00 GMT');
date_default_timezone_set("Asia/Katmandu");
$session_time = 30*60;
$_SESSION['user']['session_time'] = $session_time;
require_once "main_url.inc.php";
$URL = main_url();

$config = new config();
$dbname = $config->dbname;
$dbuser = $config->dbuser;
$dbhost = $config->dbhost;
$dbpass = $config->dbpass;

include_once "includes/db.inc.php";
$db = new Database($dbhost,$dbuser,$dbpass,$dbname) ;

include_once "includes/functions.inc.php";

$getPost = $db->query("select * from tblpost order by PostID desc");
while ($setPost = $db->fetch_object($getPost)) {

	$AllDetail = getUserDetail($setPost->UserID,$db);
	$BatchYear = $_SESSION['user']['BatchYear'];
	if($setPost->PostType == 2 and $AllDetail->BatchYear != $BatchYear) {
		$Allow = FALSE; 
	} else { $Allow = TRUE; }
	if($Allow)
	{
?>
<div class="card">
	<div class="content">
		<div class="row wall-post">
			<div class="wall-img"><img src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($setPost->UserID,$setPost->Gender,$db) ?>" class="img-responsive img-thumbnail" /></div>
			<div class="wall-desc">
				<a href="<?php echo $URL ?>user/profile.html?id=<?php echo $setPost->UserID ?>"><?php echo getUser($setPost->UserID,$db) ?></a> • <span class="batch-year"><?php echo $AllDetail->BatchYear ?></span>
				<p class="post-prop"><?php echo date("l, M dS, Y \a\\t h:ia",$setPost->PostDate) ?> • <?php echo PostType($setPost->PostType) ?></p>
				<p><?php echo $setPost->PostDesc ?></p>
			</div>
		</div>
	</div>
</div>
<?php
	}
}
?>