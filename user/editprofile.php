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
        success_alert();
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
            $db->query("update tblprofilepicture set Status = '0' where UserID = '$txtUserID'");
            $PPID = max_PK("tblprofilepicture", "ImageID", $db);
            $db->query("insert into tblprofilepicture set 
                ImageID = '$PPID',
                FileName = '$New_Name',
                UserID = '$txtUserID',
                Status = '1'
                ");
            success_alert();
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
                                <label class="" for="FirstName">First Name</label>
                                <input type="text" name="FirstName" id="FirstName" value="<?php echo $setPersonal->FirstName ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="" for="LastName">Last Name</label>
                                <input type="text" name="LastName" id="LastName" value="<?php echo $setPersonal->LastName ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="Username">Gender</label>
                                <select name="Gender" id="" class="form-control">
                                    <option value=""></option>
                                    <option <?php if($setPersonal->Gender == 1) echo "selected" ?> value="1">Male</option>
                                    <option <?php if($setPersonal->Gender == 2) echo "selected" ?> value="2">Female</option>
                                    <option <?php if($setPersonal->Gender == 3) echo "selected" ?> value="3">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="Username">Email</label>
                                <input type="text" name="Username" readonly="true" id="Username" value="<?php echo $setPersonal->Username ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="ContactNo">Contact No</label>
                                <input type="text" name="ContactNo" id="ContactNo" value="<?php echo $setPersonal->ContactNo ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="" for="BatchYear">Batch Year</label>
                                <select name="BatchYear" class="form-control" required="true">
                                    <option value=""></option>
                                    <?php
                                    $getBatchYear = $db->query("select * from tblbatchyear order by BatchYear asc");
                                    while ($setBatchYear = $db->fetch_object($getBatchYear)) {
                                    ?>
                                    <option <?php if($setBatchYear->BatchYear == $setPersonal->BatchYear) echo "selected" ?> value="<?php echo $setBatchYear->BatchYear ?>"><?php echo $setBatchYear->BatchYear ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="" for="Address">Address</label>
                                <input type="text" name="Address" id="Address" value="<?php echo $setPersonal->Address ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="Country">Country</label>
                                <select name="Country" class="form-control" required="true">
                                    <option value=""></option>
                                    <?php
                                    $getCountry = $db->query("select * from tblcountry order by CountryName asc");
                                    while ($setCountry = $db->fetch_object($getCountry)) {
                                    ?>
                                    <option <?php if($setCountry->CountryCode == $setPersonal->Country) echo "selected" ?> value="<?php echo $setCountry->CountryCode ?>"><?php echo $setCountry->CountryName ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="City">City</label>
                                <input type="text" name="City" id="City" value="<?php echo $setPersonal->City ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="PostalCode">Postal Code</label>
                                <input type="number" name="PostalCode" id="PostalCode" value="<?php echo $setPersonal->PostalCode ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="" for="AboutMe">About Me</label>
                                <textarea name="AboutMe" id="AboutMe" rows="5" class="form-control"><?php echo $setPersonal->AboutMe ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pull-right">
                                <button class="btn btn-info btn-fill btn-wd" name="btnSaveDetail">Save Detail</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rand" value="<?php echo $_SESSION['UserDetail'] ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.avatar-click').click(function(event) {
            event.preventDefault();
            $('#txtProfImage').trigger('click').change(function() {
                $('.buttonss').removeClass('hide')
            });
        });
        $('button[type="reset"]').click(function() {
            $('.buttonss').addClass('hide')
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.avatar-click').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#txtProfImage").change(function(){
            readURL(this);
        });
    });
</script>
