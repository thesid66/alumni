<?php
function pacrypt ($pw, $pw_db="") {
    $pw = stripslashes($pw);
    $password = "";
    $salt = "";
        $split_salt = preg_split ('/\$/', $pw_db);
        if (isset ($split_salt[2])) {
            $salt = $split_salt[2];
        }
        $password = md5crypt ($pw, $salt);
    return $password;
}
function md5crypt ($pw, $salt="", $magic="") {
    $MAGIC = "$1$";
    if ($magic == "") $magic = $MAGIC;
    if ($salt == "") $salt = create_salt ();
    $slist = explode ("$", $salt);
    if ($slist[0] == "1") $salt = $slist[1];
    $salt = substr ($salt, 0, 8);
    $ctx = $pw . $magic . $salt;
    $final = hex2bin (md5 ($pw . $salt . $pw));
    for ($i=strlen ($pw); $i>0; $i-=16) {
        if ($i > 16) {
            $ctx .= substr ($final,0,16);
        } else {
            $ctx .= substr ($final,0,$i);
        }
    }
    $i = strlen ($pw);
    while ($i > 0) {
        if ($i & 1) $ctx .= chr (0);
        else $ctx .= $pw[0];
        $i = $i >> 1;
    }
    $final = hex2bin (md5 ($ctx));
    for ($i=0;$i<1000;$i++) {
        $ctx1 = "";
        if ($i & 1) {
            $ctx1 .= $pw;
        } else {
            $ctx1 .= substr ($final,0,16);
        }
        if ($i % 3) $ctx1 .= $salt;
        if ($i % 7) $ctx1 .= $pw;
        if ($i & 1) {
            $ctx1 .= substr ($final,0,16);
        } else {
            $ctx1 .= $pw;
        }
        $final = hex2bin (md5 ($ctx1));
    }
    $passwd = "";
    $passwd .= to64 (((ord ($final[0]) << 16) | (ord ($final[6]) << 8) | (ord ($final[12]))), 4);
    $passwd .= to64 (((ord ($final[1]) << 16) | (ord ($final[7]) << 8) | (ord ($final[13]))), 4);
    $passwd .= to64 (((ord ($final[2]) << 16) | (ord ($final[8]) << 8) | (ord ($final[14]))), 4);
    $passwd .= to64 (((ord ($final[3]) << 16) | (ord ($final[9]) << 8) | (ord ($final[15]))), 4);
    $passwd .= to64 (((ord ($final[4]) << 16) | (ord ($final[10]) << 8) | (ord ($final[5]))), 4);
    $passwd .= to64 (ord ($final[11]), 2);
    return "$magic$salt\$$passwd";
}
function create_salt () {
    srand ((double) microtime ()*1000000);
    $salt = substr (md5 (rand (0,9999999)), 0, 8);
    return $salt;
}
if (!function_exists('hex2bin')) {
function hex2bin ($str) {
    $len = strlen ($str);
    $nstr = "";
    for ($i=0;$i<$len;$i+=2) {
        $num = sscanf (substr ($str,$i,2), "%x");
        $nstr.=chr ($num[0]);
    }
    return $nstr;
}
}

function remove_from_array($array, $item) {
    $ret = array_search($item, $array);
    if ($ret === false) {
        $found = 0;
    } else {
        $found = 1;
        unset ($array[$ret]);
    }
    return array($found, $array);
}
function to64 ($v, $n) {
    $ITOA64 = "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $ret = "";
    while (($n - 1) >= 0) {
        $n--;
        $ret .= $ITOA64[$v & 0x3f];
        $v = $v >> 6;
    }
    return $ret;
}

function FilterDateTime($field)
{
	$field =  strip_tags($field);
	return preg_replace("/[^0-9-: ]+/", "", html_entity_decode($field));	
	return $field;	
}

function notify($title, $text, $url, $noclose = TRUE, $timeout=0)
{
	?>
  <script>
  $(document).ready(function(e) {
		$('#myModal').modal('show');
  });
	</script>
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm"  style="top:25%;">
		  <div class="modal-content">
			  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="panel-title" id="myModalLabel"><strong><?php echo $title;?></strong></h4>
        </div>
        <div class="modal-body">
					<?php echo $text;?>
        </div>
				<?php if ($noclose)
				{
					?>
        <div class="modal-footer">
        <button id="close" type="button" class="btn btn-default" data-dismiss="modal" autofocus>Close</button>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
	<?php if (isset($url))
	{ ?>
<script>
/*	$('#close').click(function(e) {
		window.location='<?php echo $url;?>'; 
  }); */
	$('#myModal').on('hide.bs.modal', function (e) {
		window.location='<?php echo $url;?>'; 
	});
</script>
	<?php } ?>
	<?php if ((isset($timeout) && ($timeout > 0)))
	{
		?>
<script>
		window.setTimeout(function() { $('#myModal').modal('hide'); },<?php echo $timeout;?>);
</script>
		<?php } ?>
  <?php
}
function notify_big($title, $text, $url, $noclose = TRUE, $timeout=0)
{
	?>
  <script>
  $(document).ready(function(e) {
		$('#myModal').modal('show');
  });
	</script>
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-vertical-centered">
		  <div class="modal-content">
			  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?php echo $title;?></h4>
        </div>
        <div class="modal-body">
					<?php echo $text;?>
        </div>
				<?php if ($noclose)
				{
					?>
        <div class="modal-footer">
        <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
	<?php if (isset($url))
	{ ?>
<script>
/*	$('#close').click(function(e) {
		window.location='<?php echo $url;?>'; 
  }); */
	$('#myModal').on('hide.bs.modal', function (e) {
		window.location='<?php echo $url;?>'; 
	});
</script>
	<?php } ?>
	<?php if ((isset($timeout) && ($timeout > 0)))
	{
		?>
<script>
		window.setTimeout(function() { $('#myModal').modal('hide'); },<?php echo $timeout;?>);
</script>
		<?php } ?>
  <?php
}

function confirm($title, $text, $buttonClass,$modal_id, $form_id,$rand)
{
	?>
<div id="<?php echo $modal_id;?>" class="modal">
	<div class="modal-dialog modal-sm" style="top:25%">
      <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" aria-hidden="true" class="close">×</button>
             <h3><?php echo $title;?></h3>
        </div>
        <div class="modal-body">
             <p><?php echo $text;?></p>
        </div>
        <div class="modal-footer">
        	<form method="post" id="modal_form<?php echo $form_id;?>">
        	<button id="btnYes<?php echo $form_id;?>" class="btn btn-danger">Yes</button>
          <button data-dismiss="modal" aria-hidden="true" class="btn btn-default" autofocus>No</button>
					<input type="hidden" id="modal-input<?php echo $form_id;?>">
          <input type="hidden" id="rand" name="rand" value="<?php echo $rand;?>">
          </form>
        </div>
      </div>
    </div>
</div>
<script>
$('#btnYes<?php echo $form_id;?>').click(function() {
$('form#modal_form<?php echo $form_id;?>').submit();
$('#<?php echo $modal_id;?>').modal('hide');
});
</script>
<script>
$('.<?php echo $buttonClass;?>').click(function(e) {
	e.preventDefault();
	$('#<?php echo $modal_id;?>').removeData('bs.modal')
	$('#<?php echo $modal_id;?>').modal('show');
	var ID = $(this).data('id');
	var FORM = $(this).data('form');
	var BUTTON = $(this).data('button');
	var INPUTNAME = $(this).data('input-name');
	
	$("#btnYes<?php echo $form_id;?>").attr("class",$(this).data('class'));
	$("#btnYes<?php echo $form_id;?>").attr("name",BUTTON);
	$("#modal-input<?php echo $form_id;?>").attr("name","UserID");
	$("#modal-input<?php echo $form_id;?>").attr("name",INPUTNAME);
	$("#modal-input<?php echo $form_id;?>").val(ID);
});
</script>  
<?php
}

function confirm2($title, $text,$buttonClass,$modalID,$rand,$ID)
{
	?>
<div id="<?php echo $modalID;?>" class="modal">
	<div class="modal-dialog modal-sm" style="top:25%;">
      <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" aria-hidden="true" class="close">×</button>
             <h4 class="modal-title"><?php echo $title;?></h4>
        </div>
        <div class="modal-body">
             <p><?php echo $text;?></p>
        </div>
        <div class="modal-footer">
        	<form method="post" id="FormSubmit<?php echo $ID;?>">
        	<button id="btnYes<?php echo $ID;?>" class="btn btn-danger">Yes</button>
          <button data-dismiss="modal" aria-hidden="true" class="btn btn-default" autofocus>No</button>
          <input type="hidden" name="rand" id="rand" value="<?php echo  $rand;?>">
					<input type="hidden" id="input<?php echo $ID;?>">
          </form>
        </div>
      </div>
    </div>
</div>
<script>
$('button.<?php echo $buttonClass;?>').click(function(ev) {
	ev.preventDefault();
	$('#<?php echo $modalID;?>').removeData('bs.modal');
	var ID = $(this).data('id');
	var INPUTNAME = $(this).data('input-name');
	var URL = $(this).data('url');

	$("#input<?php echo $ID;?>").attr("name",INPUTNAME);
	$("#input<?php echo $ID;?>").val(ID);

	$("#btnYes<?php echo $ID;?>").attr("class",$(this).data('class'));
	$("#btnYes<?php echo $ID;?>").attr("name",$(this).data('button'));
	$("#FormSubmit<?php echo $ID;?>").attr("action",URL);
	});
</script>    
<?php
}

function confirm3($title, $text,$buttonClass,$modalID,$rand,$ID)
{
	?>
<div id="<?php echo $modalID;?>" class="modal">
	<div class="modal-dialog modal-sm" style="top:25%;">
      <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" aria-hidden="true" class="close">×</button>
             <h4><?php echo $title;?></h4>
        </div>
        <div class="modal-body">
             <p><?php echo $text;?></p>
        </div>
        <div class="modal-footer">
        	<form method="post" id="FormSubmit<?php echo $ID;?>">
        	<button id="btnYes<?php echo $ID;?>" class="btn btn-danger">Yes</button>
          <button data-dismiss="modal" aria-hidden="true" class="btn btn-default" autofocus>No</button>
          <input type="hidden" name="rand" id="rand" value="<?php echo  $rand;?>">
					<input type="hidden" id="input<?php echo $ID;?>">
					<input type="hidden" id="input2<?php echo $ID;?>">
          </form>
        </div>
      </div>
    </div>
</div>
<script>
$('button.<?php echo $buttonClass;?>').click(function(ev) {
	ev.preventDefault();
	$('#<?php echo $modalID;?>').removeData('bs.modal');
	var ID = $(this).data('id');
	var INPUTNAME = $(this).data('input-name');
	var ID2 = $(this).data('id2');
	var INPUTNAME2 = $(this).data('input-name2');
	var URL = $(this).data('url');

	$("#input<?php echo $ID;?>").attr("name",INPUTNAME);
	$("#input<?php echo $ID;?>").val(ID);

	$("#input2<?php echo $ID;?>").attr("name",INPUTNAME2);
	$("#input2<?php echo $ID;?>").val(ID2);

	$("#btnYes<?php echo $ID;?>").attr("class",$(this).data('class'));
	$("#btnYes<?php echo $ID;?>").attr("name",$(this).data('button'));
	$("#FormSubmit<?php echo $ID;?>").attr("action",URL);
	});
</script>

<?php
}

function success_alert() {
	?>
<div class="alert alert-info update-alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="pe-7s-close"></i>
    </button>
    <h3>Congratulations!!</h3>
    <p>All details are updated.</p>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function(){
            $('.update-alert').fadeOut();
        },3000)
    });
</script>
	<?php
}

function danger_alert() {
	?>
<div class="alert alert-danger update-alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="pe-7s-close"></i>
    </button>
    <h3>Sorry!!</h3>
    <p>There was some error while updating the system.</p>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function(){
            $('.update-alert').fadeOut();
        },3000)
    });
</script>
	<?php
}

function RandomValue($length=6)
{
	$_rand_src = array(
		array(48,57) //digits
		, array(97,122) //lowercase chars
		, array(65,90) //uppercase chars
	);
	srand ((double) microtime() * 1000000);
	$random_string = "";
	for($i=0;$i<$length;$i++){
		$i1=rand(0,sizeof($_rand_src)-1);
		$random_string .= chr(rand($_rand_src[$i1][0],$_rand_src[$i1][1]));
	}
	return $random_string;
}

function spamcheck($field)
{
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$field))
	{
		return FALSE;
	}
	else
	{
			return TRUE;
	}
}

function nepdate($txtdate)
{
	include_once "nepali.calendar.inc.php";
	$cal = new Nepali_Calendar();
	
	$engdate=explode("-",$txtdate);
	$eyear=$engdate[0];
	$emonth=$engdate[1];
	$eday=$engdate[2];
		
	$result = $cal->eng_to_nep($eyear,$emonth,$eday);
	
	if ($result[month] < 10) $txtmonth = "0$result[month]";
	else $txtmonth=$result[month];
	if ($result[date] < 10) $txtday = "0$result[date]";
	else $txtday=$result[date];
	$txtdate=$result[year] . "-" . $txtmonth . "-" . $txtday;
	return ($txtdate);
}

function engdate($txtdate)
{
	include_once "nepali.calendar.inc.php";
	$cal = new Nepali_Calendar();
	
	$engdate=explode("-",$txtdate);
	$eyear=$engdate[0];
	$emonth=$engdate[1];
	$eday=$engdate[2];
		
	$result = $cal->nep_to_eng($eyear,$emonth,$eday);
	
	if ($result[month] < 10) $txtmonth = "0$result[month]";
	else $txtmonth=$result[month];
	if ($result[date] < 10) $txtday = "0$result[date]";
	else $txtday=$result[date];
	$txtdate=$result[year] . "-" . $txtmonth . "-" . $txtday;
	return ($txtdate);
}

function nepdate_year($txtdate)
{
	include_once "nepali.calendar.inc.php";
	$cal = new Nepali_Calendar();
	
	$engdate=explode("-",$txtdate);
	$eyear=$engdate[0];
	$emonth=$engdate[1];
	$eday=$engdate[2];
		
	$result = $cal->eng_to_nep($eyear,$emonth,$eday);
	
	if ($result[month] < 10) $txtmonth = "0$result[month]";
	else $txtmonth=$result[month];
	if ($result[date] < 10) $txtday = "0$result[date]";
	else $txtday=$result[date];
	$txtdate=$result[year];
	return EngToUTF8($txtdate);
}


function EngToUTF8($string)
{
	$num = array (
	"-" => "-",
	"0" => "०",
	"1" => "१", 
	"2" => "२", 
	"3" => "३", 
	"4" => "४",
	"5" => "५",
	"6" => "६",
	"7" => "७",
	"8" => "८",
	"9" => "९");
	return strtr($string, $num); //corrected 
} 


function EngToUTF8_1($string)
{
	$num = array (
	"-" => "&#2404;",
	"0" => "&#2406;",
	"1" => "&#2407;", 
	"2" => "&#2408;", 
	"3" => "&#2409;", 
	"4" => "&#2410;",
	"5" => "&#2411;",
	"6" => "&#2412;",
	"7" => "&#2413;",
	"8" => "&#2414;",
	"9" => "&#2415;");
	return strtr($string, $num); //corrected 
} 
function EngToUTF8_old($string) //old
{
	$patterns[0] = '/0/';
	$patterns[1] = '/1/';
	$patterns[2] = '/2/';
	$patterns[3] = '/3/';
	$patterns[4] = '/4/';
	$patterns[5] = '/5/';
	$patterns[6] = '/6/';
	$patterns[7] = '/7/';
	$patterns[8] = '/8/';
	$patterns[9] = '/9/';
	$patterns[10] = '/-/';
	$replacements[0] = '/०/';
	$replacements[1] = '/१/';
	$replacements[2] = '/२/';
	$replacements[3] = '/३/';
	$replacements[4] = '/४/';
	$replacements[5] = '/५/';
	$replacements[6] = '/६/';
	$replacements[7] = '/७/';
	$replacements[8] = '/८/';
	$replacements[9] = '/९/';
	return preg_replace($patterns, $replacements, $string);
} 

function UTF8toEng($string)
{
	$patterns[0] = '0';
	$patterns[1] = '1';
	$patterns[2] = '2';
	$patterns[3] = '3';
	$patterns[4] = '4';
	$patterns[5] = '5';
	$patterns[6] = '6';
	$patterns[7] = '7';
	$patterns[8] = '8';
	$patterns[9] = '9';
	$replacements[0] = '/०/';
	$replacements[1] = '/१/';
	$replacements[2] = '/२/';
	$replacements[3] = '/३/';
	$replacements[4] = '/४/';
	$replacements[5] = '/५/';
	$replacements[6] = '/६/';
	$replacements[7] = '/७/';
	$replacements[8] = '/८/';
	$replacements[9] = '/९/';
	return preg_replace($replacements, $patterns, $string);
} 
function utf8_to_html ($data)
{
	return preg_replace("/([\\xC0-\\xF7]{1,1}[\\x80-\\xBF]+)/e", '_utf8_to_html("\\1")', $data);
}

function _utf8_to_html ($data)
{
	$ret = 0;
	foreach((str_split(strrev(chr((ord($data{0}) % 252 % 248 % 240 % 224 % 192) + 128) . substr($data, 1)))) as $k => $v)
		$ret += (ord($v) % 128) * pow(64, $k);
	return "&#$ret;";
}

function html_to_utf8 ($data)
    {
    return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '_html_to_utf8("\\1")', $data);
    }

function _html_to_utf8 ($data)
    {
    if ($data > 127)
        {
        $i = 5;
        while (($i--) > 0)
            {
            if ($data != ($a = $data % ($p = pow(64, $i))))
                {
                $ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
                for ($i; $i > 0; $i--)
                    $ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
                break;
                }
            }
        }
        else
        $ret = "&#$data;";
    return $ret;
    }

function LogGenerateArray($LogTableName,$field, $value,$db,$fields) 
//LogTable, Where Field, Where Value, $DB, Fields for Fetch * for all
{
		$strLog = "SELECT $fields FROM `$LogTableName` WHERE `$field` = '$value';";
		$queryL = $db->query($strLog);
		$row = $db->fetch_array_assoc($queryL);
		return $row;
		$db->free($queryL);
}


function LogGenerate($LogTableName,$field, $value,$db,$fields) 
//LogTable, Where Field, Where Value, $DB, Fields for Fetch * for all
{
		$strLog = "SELECT $fields FROM `$LogTableName` WHERE `$field` = '$value';";
		$queryL = $db->query($strLog);
		$row = $db->fetch_array_assoc($queryL);
		return $row;
		$db->free($queryL);
}

function AddLog($LogAction, $LogTable, $OldValue, $NewValue, $db)
{
	if (is_array($OldValue))
	{
			foreach($OldValue as $key => $value) {
				$i++;
					$OldTxt .= "$key=>$value";
					if ($i < count($OldValue)) 
					{
						$OldTxt .= "{br} \n";
					}
					else "\n";
			}
	}
	if (is_array($NewValue))
	{
			foreach($NewValue as $key => $value) {
				$j++;
					$NewTxt .= "$key=>$value";
					if ($j < count($NewValue)) 
					{
						$NewTxt .= "{br} \n";
					}
					else "\n";
			}
	}

	if (strlen($NewTxt) == 0) $NewTxt = NULL;
	if (strlen($OldTxt) == 0) $OldTxt = NULL;
	
		if ($NewTxt <> $OldTxt)
		{
			$LoginUser = $_SESSION['user']['name'];
	
			$rowLog = $db->fetch_array_assoc($db->query("select `ID` from `portal_activity_log` ORDER BY ID DESC LIMIT 0,1"));
			$LogID = $rowLog['ID'] +1;

			$strLog = "INSERT INTO `portal_activity_log` (ID, ActionDate, LogAction, LogTable, OldValue, CurrentValue,RemoteIP,ActionUser)
			VALUES ('$LogID', NOW(), '$LogAction', '$LogTable', '$OldTxt', '$NewTxt','" . $_SERVER['REMOTE_ADDR'] . "', '$LoginUser')
			";
			$db->query($strLog);
		}
}

function Old_LogGenerate($LogTableName,$field, $value,$db,$fields) //LogTable, Where Field, Where Value, $DB, Fields for Fetch * for all
	{
		$strLog = "SELECT $fields FROM `$LogTableName` WHERE `$field` = '$value';";
		$queryLog = $db->query($strLog);
		$no_of_rows = $db->num_rows($queryLog);
		$fields = $db->fetch_fields($queryLog);
		if ($no_of_rows > 0)
		{
			while ($row = $db->fetch_array($queryLog))
			{
				$j=0;
				$field=array();
				foreach ($fields as $val)
				{
					$field[] = $val->name;
					$j++;
				}
				for ($i=0; $i < $j; $i++)
				{
					$txtLog .=  "[".$field[$i]. "] => " .addslashes($row[$i])  ;
					if ($i <= count($j)) $txtLog .= ", \n";
					else $txtLog .= "\n";
				}
			}
			return $txtLog;
		}
	}

	function getPrimary($table,$db)
	{
			$query = $db->query("SHOW INDEX FROM $table WHERE `Key_name` = 'PRIMARY'");
			$row = $db->fetch_object($query);
			return $row->Column_name;
	}

	function Old_AddLog($LogAction, $LogTable, $OldValue, $NewValue, $db)
	{
		$LoginUser = $_SESSION['user']['name'];

		$rowLog = $db->fetch_array_assoc($db->query("select `ID` from `portal_activity_log` ORDER BY ID DESC LIMIT 0,1"));
		$LogID = $rowLog['ID'] +1;

	
		$strLog = "INSERT INTO `portal_activity_log` (ID, ActionDate, LogAction, LogTable, OldValue, CurrentValue,RemoteIP,ActionUser)
		VALUES ('$LogID', NOW(), '$LogAction', '$LogTable', '$OldValue','$NewValue','" . $_SERVER['REMOTE_ADDR'] . "', '$LoginUser')
		";
		$db->query($strLog);
	}

	function ShowError($heading, $txtError)
	{
?>
                            <div class="alert alert-danger alert-dismissable" id="MyAlert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4 class="panel-title"><?php echo $heading;?></h4>
                                    <?php echo $txtError;?>
                            </div>
<script>
	
	window.setTimeout(function() {
	$("#MyAlert").fadeTo(500, 0).slideUp(500, function(){
	$(this).remove(); 
	});
	}, 10000);

</script>
<?php		
	}

function makeAlias($db,$domain)
{
	$str = "SELECT username FROM mailbox WHERE domain = '$domain' AND is_temp ='N' ORDER BY username ";
	$query = $db->query($str);
	$no_of_rows = $db->num_rows($query);
	while ($row = $db->fetch_object($query))
	{
		++$i;
		if ($i == $no_of_rows)
			$goto .= $row->username;
		else
			$goto .= $row->username . ", ";
	}
	$db->free($query);
	unset($str, $query, $no_of_rows);
	
	$strSELECT = "SELECT address FROM alias WHERE address='everybody@$domain'";
	$query2 = $db->query($strSELECT);
	$no_of_rows = $db->num_rows($query2);
	
	if ($no_of_rows > 0)
	{
		$strSQL = " UPDATE alias SET goto = '$goto', modified = NOW() WHERE address = 'everybody@$domain';";
	}
	else
	{
		$strSQL = "INSERT INTO alias (address, goto,domain, created, modified, active) VALUES
		('everybody@$domain', '$goto', '$domain', NOW(), NOW(),'1');";
	}
	$q1 = $db->query($strSQL);
	
	if ($q1)
		return true;
	else
		return false;
}

function create_session($db)
{
	$session_id = session_id();
	$username = $_SESSION['user']['name'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$strINSERT = "INSERT INTO `portal_session` (`session_id`, `username`, `browser`,`remote_ip`) VALUES ('$session_id','$username','$browser','$remote_ip')";
	
	$db->query($strINSERT);
}
function check_session($db)
{
	$session_id = session_id();
	$username = $_SESSION['user']['name'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$strSELECT = "SELECT * FROM `portal_session` WHERE `session_id` = '$session_id' AND  `username` = '$username' AND `browser` = '$browser' AND `remote_ip` = '$remote_ip'";
	$query = $db->query($strSELECT);
	$session_no = $db->num_rows($query);
	if ($session_no > 0)
		return true;
	else
		return false;
	$db->free($query);
}
function update_session($db)
{
	$session_id = session_id();
	$username = $_SESSION['user']['name'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$now = time();
	$session_time = $_SESSION['user']['session_time'] ;	

$expire_time = $now - ($session_time * 2) ;
 if (check_session($db))
 {
		$strUPDATE = "UPDATE `portal_session` SET `last_activity` = '$now' 
			WHERE `session_id` = '$session_id' 
				AND  `username` = '$username' 
				AND `browser` = '$browser' 
				AND `remote_ip` = '$remote_ip'";
		$db->query($strUPDATE);
		
		$strDELETE = "DELETE FROM `portal_session` WHERE last_activity < $expire_time";
		$db->query($strDELETE);
 }
}
function destroy_session($db)
{
	$session_id = session_id();
	$username = $_SESSION['user']['name'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$strDELETE = "DELETE FROM `portal_session` WHERE `session_id` = '$session_id' AND  `username` = '$username' AND `browser` = '$browser' AND `remote_ip` = '$remote_ip'";
	$db->query($strDELETE);
}

function fy ($date)
{
	$txtfy= explode("-",$date);
	$nyear=$txtfy[0];
	$nmonth=$txtfy[1];
	if ($nmonth < 4)
	{
		$fy1 = $nyear -1;
	}
	else		$fy1 = $nyear;
	$fy2 = substr($fy1+1,2);
	return "$fy1/$fy2";
}

function max_PK($table,$id,$db) {
	$getmax = "select max($id+1) as $id from $table";
	$res = $db->query($getmax);
	$final = $db->fetch_object($res);
	if($final->$id==NULL)
	{
		return "1";
	}
	else
	{
		return $final->$id;
	}
}
function getUserDetail($UserID,$db)
{
	$getUser = $db->query("select * from tbluser where UserID = '$UserID'");
	$setUser = $db->fetch_object($getUser);

	return $setUser;
}
function getUser($UserID,$db)
{
	$getUser = $db->query("select * from tbluser where UserID = '$UserID'");
	$setUser = $db->fetch_object($getUser);

	$FullName = $setUser->FirstName." ".$setUser->LastName;
	return $FullName;
}
function getCountry($CountryCode,$db)
{
	$getCountry = $db->query("select * from tblcountry where CountryCode = '$CountryCode'");
	$setCountry = $db->fetch_object($getCountry);

	$CountryName = $setCountry->CountryName;
	return $CountryName;
}
function getUserProfilePic($UserID,$Gender,$db)
{
	$getGender = $db->query("select Gender from tbluser where UserID = '$UserID'");
	$setGender = $db->fetch_object($getGender);
	$Gender = $setGender->Gender;
	
	$getUserImage = $db->query("select * from tblprofilepicture where UserID = '$UserID' and Status = '1'");
	$setUserImage = $db->fetch_object($getUserImage);

	if($setUserImage->FileName)
	{
		$ProfilePicture = $setUserImage->FileName;
	}
	else
	{
		if($Gender == 1) {$ProfilePicture = "male.jpg"; } else if($Gender == 2) { $ProfilePicture = "female.jpg"; }
	}
	return $ProfilePicture;
}
function getGender($GID)
{
	return $GID == 1 ? "Male" : ($GID == 2 ? "Female" : "Others");
}
function PostType($GID)
{
	return $GID == 1 ? "All" : "Batch Member";
}

?>
