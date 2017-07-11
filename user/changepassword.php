<?php
if(isset($_POST['btnChange']))
{
    if($_SESSION['UserDetail'] == $_POST['rand'])
    {
        if($password == $_POST['OldPassword'])
        {
           if($_POST['NewPassword'] == $_POST['ConfirmPassword'])
           {
                $db->query("update tbluser set 
                    Password = '".$db->real_escape_string(sha1(md5($_POST['NewPassword'])))."',
                    PassUnhash = '".$db->real_escape_string($_POST['NewPassword'])."'
                    where
                    UserID      = '$txtUserID'
                ");
                notify("System Information!","Password was changed successfully.<br>Please login again with the new password.",$URL."logout.html",FALSE,3000);
                include($URL."footer.inc.php");
                die();
           }
           else
           {
                danger_alert();
           }
        }
        else
        {
            danger_alert();
        }
    }
}

$data_field = FALSE;
$getPersonal = $db->query("select * from tbluser where UserID = '$txtUserID'");
$setPersonal = $db->fetch_object($getPersonal);
$getColumns = $db->query("select * from information_schema.columns where table_schema = '$dbname' and table_name = 'tbluser' and COLUMN_COMMENT <> ''");
while ($setColumns = $db->fetch_object($getColumns)) {
    $column_name = $setColumns->COLUMN_NAME;
    if($setPersonal->$column_name != "") { $data_field = TRUE; } else { $data_field = FALSE; break; }
}
$_SESSION['UserDetail'] = randomValue(10); 

?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="card">
            <div class="header">
                <h4 class="title">Change Password</h4>
            </div>
            <div class="content">
                <form method="post" class="password-form">
                    <div class="form-group">
                        <label for="" class="">Current Password</label>
                        <input type="password" name="OldPassword" id="OldPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="">New Password</label>
                        <input type="password" name="NewPassword" id="NewPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="">Confirm Password</label>
                        <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <button name="btnChange" id="btnChange" class="btn btn-wd btn-fill btn-primary">Save Changes</button>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['UserDetail'] ?>" name="rand">
                </form>
            </div>
            
        </div>
    </div>
</div>