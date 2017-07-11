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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="Username">Email</label>
                                <input type="text" name="Username" readonly="true" id="Username" value="<?php echo $setPersonal->Username ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="" for="ContactNo">Contact No</label>
                                <input type="text" name="ContactNo" id="ContactNo" value="<?php echo $setPersonal->ContactNo ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
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
    <div class="col-md-12">
        <div class="card ">
            <div class="header">
                <h4 class="title">Global Sales by Top Locations</h4>
                <p class="category">All products that were shipped</p>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-5">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/US.png"
                                            </div>
                                        </td>
                                        <td>USA</td>
                                        <td class="text-right">
                                            2.920
                                        </td>
                                        <td class="text-right">
                                            53.23%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/DE.png"
                                            </div>
                                        </td>
                                        <td>Germany</td>
                                        <td class="text-right">
                                            1.300
                                        </td>
                                        <td class="text-right">
                                            20.43%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/AU.png"
                                            </div>
                                        </td>
                                        <td>Australia</td>
                                        <td class="text-right">
                                            760
                                        </td>
                                        <td class="text-right">
                                            10.35%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/GB.png"
                                            </div>
                                        </td>
                                        <td>United Kingdom</td>
                                        <td class="text-right">
                                            690
                                        </td>
                                        <td class="text-right">
                                            7.87%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/RO.png"
                                            </div>
                                        </td>
                                        <td>Romania</td>
                                        <td class="text-right">
                                            600
                                        </td>
                                        <td class="text-right">
                                            5.94%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flag">
                                                <img src="assets/img/flags/BR.png"
                                            </div>
                                        </td>
                                        <td>Brasil</td>
                                        <td class="text-right">
                                            550
                                        </td>
                                        <td class="text-right">
                                            4.34%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-1">
                        <div id="worldMap" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="header">
                <h4 class="title">Email Statistics</h4>
                <p class="category">Last Campaign Performance</p>
            </div>
            <div class="content">
                <div id="chartEmail" class="ct-chart "></div>
            </div>
            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-info"></i> Open
                    <i class="fa fa-circle text-danger"></i> Bounce
                    <i class="fa fa-circle text-warning"></i> Unsubscribe
                </div>
                <hr>
                <div class="stats">
                    <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="header">
                <h4 class="title">Users Behavior</h4>
                <p class="category">24 Hours performance</p>
            </div>
            <div class="content">
                <div id="chartHours" class="ct-chart"></div>
            </div>
            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-info"></i> Open
                    <i class="fa fa-circle text-danger"></i> Click
                    <i class="fa fa-circle text-warning"></i> Click Second Time
                </div>
                <hr>
                <div class="stats">
                    <i class="fa fa-history"></i> Updated 3 minutes ago
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card ">
            <div class="header">
                <h4 class="title">2014 Sales</h4>
                <p class="category">All products including Taxes</p>
            </div>
            <div class="content">
                <div id="chartActivity" class="ct-chart"></div>
            </div>
            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-info"></i> Tesla Model S
                    <i class="fa fa-circle text-danger"></i> BMW 5 Series
                </div>
                <hr>
                <div class="stats">
                    <i class="fa fa-check"></i> Data information certified
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card ">
            <div class="header">
                <h4 class="title">Tasks</h4>
                <p class="category">Backend development</p>
            </div>
            <div class="content">
                <div class="table-full-width">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                </td>
                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                    </label>
                                </td>
                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                    </label>
                                </td>
                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                </td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                </td>
                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                </td>
                                <td>Read "Following makes Medium better"</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                </td>
                                <td>Unfollow 5 enemies from twitter</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                    <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footer">
                <hr>
                <div class="stats">
                    <i class="fa fa-history"></i> Updated 3 minutes ago
                </div>
            </div>
        </div>
    </div>
</div>