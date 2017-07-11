<?php
session_start();

 if (defined("HEADER")!= "header.inc.php")
		echo "<script>window.location='" .$URL."login.html';</script>"; 

if (isset($_SESSION['moic-portal.gov.np']))
{

		$randomValue = ($_POST['password_random']);

	if (isset($_POST['btnchangepw']))
	{
		$randomValue = ($_POST['password_random']);

		if ($_SESSION['password_rand'] == $randomValue)
		{

			$currpw = sha1(md5($db->real_escape_string($_POST['currpw'])));
			$pw_un = $db->real_escape_string($_POST['pw1']);
			$pw1 =  sha1(md5($db->real_escape_string($_POST['pw1'])));
			$pw2 =  sha1(md5($db->real_escape_string($_POST['pw2'])));
			unset($isPasswordError, $pw_error);

			//Error Checking
			$isPasswordError = FALSE;
	
			if (strlen($currpw) == 0)
			{
				$isPasswordError = TRUE;
				$pw_error[] = "Enter Old Password";	
			}
			else
			{
				$user = $_SESSION['user']['username'];
				$strSQL = "select * from `tbluser` where `Username` = '$user'; ";
				
				$queryPW = $db->query($strSQL);
				$rowPW = $db->fetch_object($queryPW);
				$pw = $rowPW->Password;
				$db->free($queryPW);
				
				if($pw != $currpw)
				{
					$isPasswordError = TRUE;
					$pw_error[] = "Old password didn't match";
				}
			}
			if (strlen($pw1) == 0)
			{
				$isPasswordError = TRUE;
				$pw_error[] = "Enter New Password";	
			}
			if (strlen($pw2) == 0)
			{
				$isPasswordError = TRUE;
				$pw_error[] = "Enter Confirm Password";	
			}
			
			if ($pw1 != $pw2)
			{
				$isPasswordError = TRUE;
				$pw_error[] = "New and Confirm Password Didn't match";
			}
				
			if ($isPasswordError == FALSE)
			{
				if ($_SESSION['FirstTime'])
				{
					$LastLogin = time();
					$strReset = ("UPDATE `tbluser` SET `Password` = '$pw1', `PassUnhash` = '$pw_un', LoginTime = '$LastLogin'  WHERE `username` = '" . $_SESSION['user']['name'] . "';");
					unset($_SESSION['FirstTime']);
				}
				else
				{
					$strReset = ("UPDATE `tbluser` SET `Password` = '$pw1', `PassUnhash` = '$pw_un' WHERE `username` = '" . $_SESSION['user']['name'] . "';");
					
				}
				$queryReset = $db->query($strReset);

				if ($queryReset)
				{
					unset($_SESSION['moic-portal.gov.np']);
					session_destroy();
					notify("Change Password","Password has been successfully changed.<br> Please login with new password.","login.html",TRUE,10000);
				}
				
			}		// NO ERROR
		}		//random value check
	}
?>
<?php 
if ($isPasswordError)
{
	$CountERROR = count($pw_error);
	$text = "<ul>";
	for($i=0;$i<$CountERROR;$i++)
	{
		$text .= "<li>" . $pw_error[$i] . "</li>";
	}
	$text .= "</ul></b></font>";

	notify("Error","<font color=\"red\">$text</font>",NULL,TRUE, 10000);
	?>
<?php    
}
?>
<?php
$password_rand = RandomValue(15);
$_SESSION['password_rand']=$password_rand;
?>
    <!-- Change Password -->
    <div style="display: none;" class="modal fade" id="changepw" tabindex="-1" role="dialog" aria-labelledby="mychangepwlabel" aria-hidden="true">
      <div class="modal-dialog" style="margin-top:7%;">
        <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="mychangepwlabel"><strong>Change Password</strong></h4>
          </div>
          <div class="modal-body">
            <form  method="post" role="form" name="form-change-pw" id="form-change-pw" class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-4 control-label">Current Password</label>
                <div class="col-sm-8">
                  <input type="password" name="currpw" id="currpw" class="form-control" placeholder="Current Password" />
                </div>
              </div>
    
              <div class="form-group">
                <label class="col-sm-4 control-label">New Password</label>
                <div class="col-sm-8">
                  <input type="password" name="pw1" id="pw1" class="form-control" placeholder="New Password" />
                </div>
              </div>
    
              <div class="form-group">
                <label class="col-sm-4 control-label">Verify New Password </label>
                <div class="col-sm-8">
                  <input type="password" name="pw2" id="pw2" class="form-control" placeholder="Verify New Password" />
                </div>
              </div>
    
          <div class="modal-footer">
            <button id ="btnchangepw" name="btnchangepw" type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Change Password</button>
            <input type="hidden" name="password_random" value="<?php echo $password_rand;?>">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.change password -->
<?php 
 }
?>