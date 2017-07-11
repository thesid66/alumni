<?php
if (!defined("ALUMNI")) die("not authorized");
function main_url()
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
class config
{
	public $dbname = 'alumnidb';
	public $dbuser = 'root';
	public $dbpass = '';
	public $dbhost = 'localhost';
	public $vacation_domain = 'vacation.invalid';
	public $quota_devider = '1048576';		//MB
	public $mail_server = 'localhost';		//Host Name of Mail Server
	public $imap_port = '143';		//MB
}

function removeExtraCharacter($field)
{
	return preg_replace("/[^a-zA-Z0-9_-]+/", "", htmlspecialchars(html_entity_decode(strip_tags($field))));
}
function FilterString($field)
{
	$field =  strip_tags($field);
	$field = preg_replace("/[;]+/", "", html_entity_decode($field));	
	$field = htmlspecialchars($field,ENT_QUOTES,'UTF-8');
	$field = htmlentities($field, ENT_QUOTES,'UTF-8');
	$field =  str_replace("--","",($field));
	return $field;
}
function FilterTextBox($field)
{
	$field =  strip_tags($field);
	$field = preg_replace("/[;]+/", "", html_entity_decode($field));	
	$field =  str_replace("--","",($field));
	return $field;
}

function FilterNumber($field)
{
	return preg_replace("/[^0-9]+/", "", htmlspecialchars(html_entity_decode(strip_tags($field))));	
}
function FilterDate($field)
{
	return preg_replace("/[^0-9-]+/", "", htmlspecialchars(html_entity_decode(strip_tags($field))));		
}	

function FilterEmail($field)
{
	return preg_replace("/[a-zA-Z0-9][_][-][@]+ /", "", html_entity_decode($field));
}

function validDomain($domain)
{
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain) //valid chars check
            && preg_match("/^.{1,253}$/", $domain) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain)   ); //length of each label
}
function getDir()
{
	$dir    = dirname(__FILE__);
	$directories = scandir($dir);
	for ($i=0;$i<count($directories);$i++)
	{
			if (is_dir($directories[$i])) 
			{
				if(! preg_match("/_/i",$directories[$i])
				&& $directories[$i] != "."
				&& $directories[$i] != ".."
/*				&& $directories[$i] != "portal"
				&& $directories[$i] != "mail"
				&& $directories[$i] != "includes"
				&& $directories[$i] != "font-awesome-4.1.0"
				&& $directories[$i] != "bootstrap" */
				) 
				$dir2[] = $directories[$i];
			}
	}
	return $dir2;
}
function getDirFile($directory)
{
	$dir    = dirname(__FILE__);
	$DS=DIRECTORY_SEPARATOR;
	if ($DS=="\\") $DS = "/";

	$dir3 = $dir . $DS . $directory;

	$dirFile = scandir($dir3);
	natcasesort($dirFile);
	foreach ($dirFile as $DIRFILE)
	{
		$ext = pathinfo($DIRFILE,PATHINFO_EXTENSION);
		if (($ext == "php") || ($ext =="html") || ($ext == "htm"))
		{
			$dir_file[] = $DIRFILE;
		}
	}
	return $dir_file;
}