<?php
if(isset($_POST['btnSaveDetail']))
{
    if($_SESSION['UserDetail'] == $_POST['rand'])
    {
        $db->query("update tbluser set 
            FirstName   = '".$db->real_escape_string($_POST['FirstName'])."',
            LastName    = '".$db->real_escape_string($_POST['LastName'])."',
            Gender      = '".$db->real_escape_string($_POST['Gender'])."',
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
$data_field = FALSE;
$getPersonal = $db->query("select * from tbluser where UserID = '$txtUserID'");
$setPersonal = $db->fetch_object($getPersonal);
$getColumns = $db->query("select * from information_schema.columns where table_schema = '$dbname' and table_name = 'tbluser' and COLUMN_COMMENT <> ''");
while ($setColumns = $db->fetch_object($getColumns)) {
    $column_name = $setColumns->COLUMN_NAME;
    if($setPersonal->$column_name != "") { $data_field = TRUE; } else { $data_field = FALSE; break; }
}
$_SESSION['UserDetail'] = randomValue(10); 
if($data_field == FALSE)
{
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Update Personal Detail</h4>
                <p class="category">Please update your detail to let everyone know about yourself</p>
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
                                <label for="Gender" class="">Gender</label>
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
</div>
<?php
}
?>
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="content-header">
                <p>Create Post</p>
            </div>
            <form method="post">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="txtPostDesc" placeholder="Say Something"></textarea>
                        </div>
                    </div>
                    <div class="row content-button-div">
                        <div class="col-sm-12">
                            <div class="pull-left">
                                <select name="txtPostType" class="form-control">
                                    <option value="1">Public</option>
                                    <option value="2"><?php echo $BatchYear ?> Batch Mates</option>
                                </select>
                            </div>
                            <div class="pull-right">
                                <button name="btnPost" class="btn btn-success btn-fill btn-wd">Post</button>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="rand" value="<?php echo $_SESSION['UserDetail'] ?>">
            </form>
        </div>
        <div class="wall-post"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
                type: "POST",
                async: false, //SO THAT IT WAITS FOR THE LOAD BEFORE CONTINUING
                url: "<?php echo $URL; ?>listpost.php",
                success: function(result) {
                    $(".wall-post").append(result);
                }
            });
        $(window).scroll(function() {
            listtitle();
        });

        function listtitle() {
            alert("in ajax");
            $.ajax({
                type: "POST",
                async: false, //SO THAT IT WAITS FOR THE LOAD BEFORE CONTINUING
                url: "<?php echo $URL; ?>listpost.php",
                success: function(result) {
                    $(".wall-post").append(result);
                }
            });
        }
    });
</script>