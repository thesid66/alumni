<?php
session_start();
if (defined("HEADER")!= "header.inc.php")
        echo "<script>window.location='login.html';</script>"; 

if ($_POST['logout'] == "true") 
{
    unset ($_SESSION['moic-portal.gov.np']);
    unset ($_SESSION['user']['name']);
    $_SESSION['logout'] = true;
}

    include_once "includes/db.inc.php";
    $db = new Database($dbhost,$dbuser,$dbpass,$dbname);

if (isset($_POST['btnLogin']))
{
    $randomValue = ($_POST['rand']);
    if ($_SESSION['list_user'] == $randomValue)
    {
        $username = $db->real_escape_string($_POST['txtUser']);
        $password = sha1(md5($db->real_escape_string($_POST['txtPass'])));

        ($query = "SELECT * from tbluser where Username='$username' and Password = '$password'");

        $query_result=$db->query($query);
        $no_of_rows = $db->num_rows($query_result);
    
        $row= $db->fetch_object($query_result);
    
        if($no_of_rows>0)
            $isAuthenticated=TRUE;
        else
            $isAuthenticated=FALSE;
    
        if ($no_of_rows == 0 || $isAuthenticated == FALSE)
        {
                unset ($_SESSION['moic-portal.gov.np']);
                $isError = TRUE;
                $txtError = "Email and Password didn't match";
        }
        if ($isAuthenticated)
        {
                $username = $row->Username;
                $name= $row->FirstName." ".$row->LastName;
                $password = $row->PassUnhash;
                $txtUserID = $row->UserID;
                $Status = $row->Status;
                $UserType = $row->UserType;
                $LastLogin = $row->LoginTime;
                $BatchYear = $row->BatchYear;
                $Gender = $row->Gender;
                
                
                if ($Status != "0") //if not active a/c
                {
                    unset ($_SESSION['moic-portal.gov.np']);
                    unset ($_SESSION['user']);
                    $isError = TRUE;
                    $txtError =  "You don't have rights to access the application. Please contact System Administrator";
                }

                else if ($Status == "0")
                {
                    session_regenerate_id();
                    $_SESSION['moic-portal.gov.np']= true;
                    $_SESSION['user']['username'] = $username;
                    $_SESSION['user']['name'] = $username;
                    $_SESSION['user']['ID'] = $txtUserID;
                    $_SESSION['user']['fullname'] = $name;
                    $_SESSION['user']['fy'] = $fy;
                    $_SESSION['user']['UserType'] = $UserType;
                    $_SESSION['user']['BatchYear'] = $BatchYear;
                    $_SESSION['user']['Gender'] = $Gender;
                    $_SESSION['user']['password'] = $password;
    
                    $_SESSION['expire'] = time() + $session_time ;
    
                    $_SESSION['editmode'] = "no";
    
                    if ($LastLogin == "")
                    {
                        $txtError = "Please change the password";
                        $_SESSION['FirstTime'] = TRUE;
                        ?>
                    <div class="col-md-12" style="margin-top:10px;">
                    <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo "<b>$txtError</b>";?>
                    </div>
                    </div>
                    
                    <script type="text/javascript">
                    $(window).load(function(ev) {
                        $('#changepw').modal('show');  
                    });
                    </script>
                        
                        <?php
                    }
                    else
                    {
                        ?>

                                            
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4">
                        <?php 
                        $LastLogin = time();
                        create_session($db);
                        $db->query("UPDATE tbluser SET LoginTime = '$LastLogin' WHERE UserID='$txtUserID'");
                        notify("Welcome","<b>MASIT Alumni Association Portal</b>", 
                        $URL ."dashboard.html", FALSE,2000);
                        
                        ?>
                        </div>
                    </div>
             
                <?php 
                include_once "fo+oter.inc.php";
                die();
                    }
                }   
            }
        }
    }

if ($_SESSION['FirstTime'])
{
    include_once "changepw.php";
}

    $rand = RandomValue(10);
    $_SESSION['list_user']=$rand;
?>

       
<?php 
if ($isError)
{
?>
    <script>
    window.setTimeout(function()
    {
      $("#alert").fadeTo(100, 0).slideUp(100, function(){
      $(this).remove(); 
      });
    }, 3000);
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
            <a class="navbar-brand" href="dashboard.html">MASIT Alumni Association</a>
        </div>
        <div class="collapse navbar-collapse">       
            
            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="<?php echo $URL; ?>register.html">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="wrapper wrapper-full-page">

    <div class="full-page login-page" data-color="orange" data-image="assets/img/full-screen-image-1.jpg">   
        
    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
            <?php
    if ($isError) 
{
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $.notify({
            icon: 'pe-7s-attention',
            message: "<?php echo $txtError; ?>"

        },{
            type: 'danger',
            timer: 1000,
            placement: {
                from: 'top',
                align: 'center'
            }
        });
    });
        
    </script>
<!-- <div class="" style="width:auto; right:10px; overflow:visible; position:absolute">
<div class="alert alert-warning alert-dismissable" id="alert">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span class="fa fa-times"></span></button>
  <?php echo "<b>$txtError</b>";?> asdfa sdf asd fasdf asd fa sdf asd fasdf 
</div>
</div> -->
<?php } ?>  
                <div class="row">                   
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <form method="post" action="" id="Login-Form">
                            
                        <!--   if you want to have the card without animation please remove the ".card-hidden" class   -->
                            <div class="card card-hidden">
                                <div class="header text-center">Login</div>
                                <div class="content">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" placeholder="Enter email" name="txtUser" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" placeholder="Password" name="txtPass" class="form-control">
                                    </div>                                    
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" name="btnLogin" class="btn btn-fill btn-warning btn-wd">Login</button>
                                </div>
                            </div>
                                <input type="hidden" name="rand" value="<?php echo $_SESSION['list_user'] ?>">
                        </form>
                                
                    </div>                    
                </div>
            </div>
        </div>
    	
    	<footer class="footer footer-transparent">
            <div class="container">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Back to Website
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <?php echo date("Y") ?>  Developers: <a href="http://www.gautamsiddhartha.com.np/" target="_blank">Siddhartha Gautam</a> & <a href="http://www.anamolnepal.pro.np" target="_blank">Anamol Nepal</a>
                </p>
            </div>
        </footer>

    </div>                             
       
</div>
<?php
    $db->close();
?>