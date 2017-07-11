<?php
$URL = main_url2();

if (!($_SESSION['moic-portal.gov.np']) )
{
		echo "<script>window.location='" .$URL."login.html';</script>"; 
		exit();
}
if (defined("HEADER")!= "header.inc.php")
{
		echo "<script>window.location='" .$URL."login.html';</script>"; 
		exit();
}



function main_url2()
{
	$HOST="http://".$_SERVER['HTTP_HOST'];
	$ROOT_DIR= $_SERVER['DOCUMENT_ROOT'];
	$DS=DIRECTORY_SEPARATOR;
	if ($DS=="\\") $DS = "/";
	$filedir = dirname(__FILE__);
	$filedir=str_replace("\\",$DS,$filedir);
	$filedir=str_replace($ROOT_DIR,"",$filedir);
	$basename = $HOST . $DS . $filedir;
	
	$basename = $basename."/";
	$basename = str_replace("//","/",$basename);
	$basename = str_replace("http:/","http://",$basename);
	return $basename;
}
?>