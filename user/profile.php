<?php
if(isset($_POST['btnSaveDetail']))
{
    if($_SESSION['UserDetail'] == $_POST['rand'])
    {
        $db->query("update tbluser set 
            FirstName   = '".$db->real_escape_string($_POST['FirstName'])."',
            LastName    = '".$db->real_escape_string($_POST['LastName'])."',
            Address     = '".$db->real_escape_string($_POST['Address'])."',
            Country     = '".$db->real_escape_string($_POST['Country'])."',
            City        = '".$db->real_escape_string($_POST['City'])."',
            PostalCode  = '".$db->real_escape_string($_POST['PostalCode'])."',
            AboutMe     = '".$db->real_escape_string($_POST['AboutMe'])."',
            ContactNo   = '".$db->real_escape_string($_POST['ContactNo'])."',
            BatchYear   = '".$db->real_escape_string($_POST['BatchYear'])."'
            where
            UserID      = '$txtUserID'
        ");
        ?>
        <div class="alert alert-success update-alert">
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
}

if(isset($_POST['btnPost']))
{
    if($_SESSION['UserDetail']==$_POST['rand'])
    {
        $PostID = max_PK("tblpost","PostID",$db);
        $db->query("insert into tblpost set
            PostID  = '$PostID',
            UserID  = '$txtUserID',
            PostDate    = '".time()."',
            PostType    = '".$db->real_escape_string($_POST['txtPostType'])."',
            PostDesc    = '".$db->real_escape_string($_POST['txtPostDesc'])."'
            ");
    }
}
if(isset($_POST['btnAddPP']))
{
    if($_SESSION['UserDetail'] == $_POST['rand'])
    {
        $uName = explode("@",$username);

        $temp_name = $_FILES['txtProfImage']['name'];
        $Array_name = explode('.',$temp_name);
        $New_Name = $uName[0]."_profile_".time().".".end($Array_name);
        if(move_uploaded_file($_FILES['txtProfImage']['tmp_name'], $URL."user/profilepicture/".$New_Name))
        {
            echo "File Moved";
        }
        else
        {
            echo "file didn't move";
        }
    }
}
$data_field = FALSE;
if(isset($_GET['id']))
{
    $getPersonal = $db->query("select * from tbluser where UserID = '".$_GET['id']."'");
}
else
{
    $getPersonal = $db->query("select * from tbluser where UserID = '$txtUserID'");
}
$setPersonal = $db->fetch_object($getPersonal);
$getColumns = $db->query("select * from information_schema.columns where table_schema = '$dbname' and table_name = 'tbluser' and COLUMN_COMMENT <> ''");
while ($setColumns = $db->fetch_object($getColumns)) {
    $column_name = $setColumns->COLUMN_NAME;
    if($setPersonal->$column_name != "") { $data_field = TRUE; } else { $data_field = FALSE; break; }
}
$_SESSION['UserDetail'] = randomValue(10); 

?>
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="header">
                <h4 class="title">Personal Detail</h4>
            </div>
            <div class="content">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="" for="FirstName">First Name</label><br>
                                <b><?php echo $setPersonal->FirstName ?></b>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="" for="LastName">Last Name</label><br>
                                <b><?php echo $setPersonal->LastName ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="Username">Gender</label><br>
                                <b><?php echo getGender($setPersonal->Gender) ?></b>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="Username">Email</label><br>
                                <b><?php echo $setPersonal->Username ?></b>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="ContactNo">Contact No</label><br>
                                <b><?php echo $setPersonal->ContactNo ?></b>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="BatchYear">Batch Year</label><br>
                                <b><?php echo $setPersonal->BatchYear ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="" for="Address">Address</label><br>
                                <b><?php echo $setPersonal->Address ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="Country">Country</label><br>
                                <b><?php echo getCountry($setPersonal->Country,$db) ?></b>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="City">City</label><br>
                                <b><?php echo $setPersonal->City ?></b>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="PostalCode">Postal Code</label><br>
                                <b><?php echo $setPersonal->PostalCode ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="" for="AboutMe">About Me</label><br>
                                <b><?php echo $setPersonal->AboutMe ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-user">
            <form method="post" enctype="multipart/form-data">
                <div class="content">
                    <div class="author">
                         <a href="#">
                        <img class="avatar border-gray avatar-click" src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($setPersonal->UserID,$Gender,$db) ?>" alt="..."/>

                          <h4 class="title"><?php echo $setPersonal->FirstName." ".$setPersonal->LastName ?><br />
                             <small><?php echo $setPersonal->Username ?></small>
                          </h4>
                        </a>
                    </div>
                    <p class="description text-center"> "<?php echo $setPersonal->AboutMe ?>"
                    </p>
                
                    <input type="file" name="txtProfImage" class="hidden" id="txtProfImage">
                </div>
                <div class="buttonss hide">
                    <div class="btn-group btn-block">
                        <button class="btn btn-primary btn-fill btn-wd" name="btnAddPP" type="submit">Save Changes</button>
                        <button class="btn btn-danger btn-fill btn-wd" type="reset">Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="rand" value="<?php echo $_SESSION['UserDetail'] ?>">
            </form>
            <hr>
            <div class="text-center">
                <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Photos</h4>
            </div>
            <div class="content">
                <a href="<?php echo $URL ?>gallery/gallery.html?id=p" class="gallery-block">
                    <img src="<?php echo $URL ?>user/profilepicture/male.jpg">
                    <?php
                    $getPP=$db->query("select * from tblprofilepicture where UserID = '$txtUserID'");
                    ?>
                    <span class="gallery-title"><span>Profile Picture (<?php echo $db->num_rows($getPP) ?>)</span></span>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>