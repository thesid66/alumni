<?php
$insert = FALSE;
if(isset($_POST['btnRegister']))
{
    if($_SESSION['register'] == $_POST['rand'])
    {
        $getDNS = explode("@",$_POST['txtEmail']);
        if(checkdnsrr($getDNS[1]))
        {
            $UserID = max_PK("tbluser","UserID",$db);
            $db->query("insert into tbluser set 
                UserID      = '$UserID',
                Username    = '{$db->real_escape_string($_POST['txtEmail'])}',
                Password    = '{$db->real_escape_string(sha1(md5($_POST['txtPassword'])))}',
                PassUnhash  = '{$db->real_escape_string($_POST['txtPassword'])}',
                FirstName   = '{$db->real_escape_string($_POST['txtFirstName'])}',
                LastName    = '{$db->real_escape_string($_POST['txtLastName'])}',
                Address     = '',
                ContactNo   = '',
                BatchYear   = '{$db->real_escape_string($_POST['txtBatchYear'])}',
                LoginTime   = '',
                Status      = '1'
                ");

            $insert = TRUE;
            $alert_class = "success";
            $message = "<h2>User successfully added</h2>
                        <p>Please go to you email to confirm your registration</p>";
        }
        else
        {
            $insert = TRUE;
            $alert_class = "danger";
            $message = "<h2>User could not be added</h2>
                        <p>Please check your email before the registration</p>";
        } 
    }
}

$_SESSION['register'] = randomValue(10);

if($insert == TRUE)
{
    ?>
    <div class="alert alert-<?php echo $alert_class ?> register-alert">
        <?php echo $message ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function(){
                $('.alert').hide()
            },5000)
        });
    </script>
    <?php
}
?>
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="<?php echo $URL; ?>login.html">
                        Looking to login?
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper wrapper-full-page">
    <div class="full-page register-page" data-color="orange" data-image="assets/img/full-screen-image-2.jpg">

    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="header-text">
                            <h2>MASIT Alumni Association</h2>
                            <h4>Register for free and get connected with your friends</h4>
                            <hr />
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-user"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Free Account</h4>
                                Create a free account to get connected to the mates you knew back in college
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-graph1"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Share Information</h4>
                                You can share details and information with all the friends you know

                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-headphones"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Get Support</h4>
                                Connecting with your friends can support on different causes

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-md-offset-s1">
                        <form method="post" action="" id="registration-form">
                            <div class="card card-plain">
                                <div class="content">
                                    <div class="form-group">
                                        <input required="true" type="text" name="txtFirstName" placeholder="Your First Name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input required="true" type="text" name="txtLastName" placeholder="Your Last Name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="txtBatchYear" class="form-control" required="true">
                                            <option value=""></option>
                                            <?php
                                            $getBatchYear = $db->query("select * from tblbatchyear order by BatchYear asc");
                                            while ($setBatchYear = $db->fetch_object($getBatchYear)) {
                                                ?>
                                                <option value="<?php echo $setBatchYear->BatchYear ?>"><?php echo $setBatchYear->BatchYear ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input required="true" type="email" name="txtEmail" placeholder="Enter email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input required="true" type="password" name="txtPassword" id="txtPassword" placeholder="Password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input required="true" type="password" name="txtConfirm" id="txtConfirm" placeholder="Password Confirmation" class="form-control">
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" name="btnRegister" class="btn btn-fill btn-neutral btn-wd">Create Free Account</button>
                                </div>
                            </div>
                            <input type="hidden" name="rand" value="<?php echo $_SESSION['register'] ?>">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    	<footer class="footer footer-transparent">
            <div class="container">
                <p class="copyright text-center">
                     &copy; <?php echo date("Y") ?>  Developers: <a href="http://www.gautamsiddhartha.com.np/" target="_blank">Siddhartha Gautam</a> & <a href="http://www.anamolnepal.pro.np" target="_blank">Anamol Nepal</a>
                </p>
            </div>
        </footer>

    </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#txtPassword').keyup(function() {
            error_msg = checkPwd($(this).val())

            if(error_msg == "ok")
            {
                $('.password-error').html("")
                $(this).parent('div.form-group').removeClass('has-error');
                $(this).next("span.password-error").remove();
            }
            else
            {
                $(this).parent('div.form-group').addClass('has-error');
                if($('.password-error').length == 0)
                {
                    $(this).parent('div.form-group').append('<span class="label label-info password-error">'+error_msg+"</div>")
                }
                else
                {
                    $('.password-error').html(error_msg);
                }
            }
        }); 
        function checkPwd(str) {
            if (str.length < 8) {
                return("Password must be minimum of 8 character");
            } else if (str.length > 50) {
                return("Sorry! the exceeded the length of 50");
            } else if (str.search(/\d/) == -1) {
                return("Password should also contain any number");
            } else if (str.search(/[a-z]/) == -1) {
                return("Password should also have atleast 1 lowercase character");
            } else if (str.search(/[A-Z]/) == -1) {
                return("Password should also have atleast 1 uppercase character");
            } else if (str.search(/[@\#\$\%\^\&\*\(\)]/) == -1) {
                return("Password must contain atleast 1 symbol");
            } else if (str.search(/[^a-zA-Z0-9\@\#\$\%\^\&\*]/) != -1) {
                return("Opps!! some character is invalid here.");
            } else {
                return("ok");
            }
        }

        $('#txtConfirm').keyup(function() {
            pass_word = $('#txtPassword').val();
            confirm_pass = $(this).val();
            if(pass_word == confirm_pass)
            {
                $('.confirm-error').html("")
                $(this).parent('div.form-group').removeClass('has-error');
                $(this).next("span.confirm-error").remove();
            }
            else
            {
                $(this).parent('div.form-group').addClass('has-error');
                if($('.confirm-error').length == 0)
                {
                    $(this).parent('div.form-group').append('<span class="label label-info confirm-error">Confirm Password didn\'t match</div>')
                }
                else
                {
                    $('.confirm-error').html("Confirm Password didn\'t match");
                }
            }
        });

        
    });
</script>