<?php
error_reporting(0);
header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 1 Jan 2000 00:00:00 GMT');
date_default_timezone_set("Asia/Katmandu");
$session_time = 60*60;
$_SESSION['user']['session_time'] = $session_time;
require_once "main_url.inc.php";
$URL = main_url();
$no_of_parameter = strlen(trim($_GET['page']));
if ($no_of_parameter > 0)
{ $get = $_GET['page']; }
else
{ header("Location:".$URL."dashboard.html");}
$config = new config();
$dbname = $config->dbname;
$dbuser = $config->dbuser;
$dbhost = $config->dbhost;
$dbpass = $config->dbpass;
$vacation_domain = $config->vacation_domain;
$quota_devider  = $config->quota_devider;
$mail_server = $config->mail_server;
$imap_port = $config->imap_port;
unset($config);
include_once "includes/functions.inc.php";
$username = $_SESSION['user']['name'] ;
$fullname = $_SESSION['user']['fullname'] ;
$UserType = $_SESSION['user']['UserType'] ;
$Gender = $_SESSION['user']['Gender'];
$txtUserID = $_SESSION['user']['ID'] ;
$password = $_SESSION['user']['password'];
$BatchYear = $_SESSION['user']['BatchYear'];
$fy = $_SESSION['user']['fy'];
$get = FilterString(($get));
if ($get == "login" || $get == "register")
$DisplayMenu = FALSE;
else if ($get == "logout")
$DisplayMenu = FALSE;
else
$DisplayMenu = TRUE;
$file = $get.".php";
if (file_exists($file))
{
$page = ($file);
$isPage = TRUE;
}
if (! $isPage)
header("Location:".$URL."login.html");
if ( !(constant("ALUMNI") == "TRUE")
|| !(constant("OWNER") == "IT EXPERT")
|| !(constant("ADDRESS") == "SUKEDHARA"))
header("Location:".$URL."login.html");
if ($DisplayMenu)
{
if (!($_SESSION['moic-portal.gov.np']) )
{
echo "<script>window.location='" .$URL."login.html';</script>";
exit();
}
else if (constant("HEADER")!= "header.inc.php")
{
echo "<script>window.location='" .$URL."login.html';</script>";
exit();
}
}
include_once "includes/db.inc.php";
$db = new Database($dbhost,$dbuser,$dbpass,$dbname) ;
?>
<!doctype html>
<html lang="en">
  <!-- Mirrored from demos.creative-tim.com/light-bootstrap-dashboard-pro/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 28 Apr 2017 03:51:37 GMT -->
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="<?php echo $URL ?>assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>MASIT Alumni Association</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    
    
    <!-- Canonical SEO -->
    <link rel="canonical" href="http://www.himalayansherpa.ch"/>
    
    <!--  Social tags      -->
    <meta name="keywords" content="University of Lausanne, UNIL, MASIT, Master of Advanced Studies in International Taxation, ALUMNI, Association, Switzerland, College, Friends, group">
    
    <meta name="description" content="The Master of Advanced Studies in International Taxation (MASIT) offered by the University of Lausanne (UNIL), Switzerland is aimed at those wishing to practice tax law with a law or consulting firm, a bank, as an in-house counsel to a company or with the tax administration. As the MASIT is designed for those practicing abroad or in Switzerland, it offers both an International tax and Swiss tax curriculum which may be undertaken on a part-time basis (1.5 to 2 years) or on a full time basis (1 year)">
    
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="MASIT Alumni Association">
    <meta itemprop="description" content="Welcome to the zone where you find your old mates.">
    
    <meta itemprop="image" content="http://s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg">
    <!-- Twitter Card data -->
    
    <meta name="twitter:card" content="MASIT">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="MASIT Alumni Association">
    
    <meta name="twitter:description" content="Welcome to the zone where you find your old mates.">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image" content="http://s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg">
    
    <!-- Open Graph data -->
    <meta property="og:title" content="Welcome to the zone where you find your old mates." />
    <meta property="og:type" content="MASIT" />
    <meta property="og:url" content="http://www.himalayansherpa.ch" />
    <meta property="og:image" content="http://s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg"/>
    <meta property="og:description" content="The Master of Advanced Studies in International Taxation (MASIT) offered by the University of Lausanne (UNIL), Switzerland is aimed at those wishing to practice tax law with a law or consulting firm, a bank, as an in-house counsel to a company or with the tax administration. As the MASIT is designed for those practicing abroad or in Switzerland, it offers both an International tax and Swiss tax curriculum which may be undertaken on a part-time basis (1.5 to 2 years) or on a full time basis (1 year)" />
    <meta property="og:site_name" content="MASIT Alumni" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo $URL ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    
    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="<?php echo $URL ?>assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo $URL ?>assets/css/demo.css" rel="stylesheet" />
    
    
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="https://cdn.bootcss.com/pixeden-stroke-7-icon/1.2.3/dist/pe-icon-7-stroke.css" rel="stylesheet" />
    
    <!--   Core JS Files and PerfectScrollbar library inside jquery.ui   -->
    <script src="<?php echo $URL ?>assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $URL ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo $URL ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
  </head>
  <body>
    <?php if($DisplayMenu) { ?>
    <div class="wrapper">
      <div class="sidebar" data-color="orange" data-image="<?php echo $URL ?>assets/img/full-screen-image-3.jpg">
        <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
        -->
        
        <div class="sidebar-wrapper">
          <div class="user">
            <div class="photo">
              <img src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($txtUserID,$Gender,$db) ?>" />
            </div>
            <div class="info">
              <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                <?php echo $fullname ?>
                <b class="caret"></b>
              </a>
              <div class="collapse" id="collapseExample">
                <ul class="nav">
                  <li><a href="<?php echo $URL ?>user/profile.html">My Profile</a></li>
                  <li><a href="<?php echo $URL ?>user/editprofile.html">Edit Profile</a></li>
                  <li><a href="<?php echo $URL ?>user/changepassword.html">Change Password</a></li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="nav">
            <li class="active">
              <a href="<?php echo $URL ?>dashboard.html">
                <i class="pe-7s-graph"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <?php
            $dir = getDir();
            foreach ($dir as $key) {
              if(file_exists($key."/index.php"))
              {
                include_once($key."/index.php");
              }
            }
            ?>
          </ul>
        </div>
      </div>
      <div class="main-panel">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-warning btn-fill btn-round btn-icon">
              <i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
              <i class="fa fa-navicon visible-on-sidebar-mini"></i>
              </button>
            </div>
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><?php echo $_GET['page'] ?></a>
            </div>
            <div class="collapse navbar-collapse">
              <form class="navbar-form navbar-left navbar-search-form" role="search">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-search"></i></span>
                  <input type="text" value="" class="form-control" placeholder="Search...">
                </div>
              </form>
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="charts.html">
                    <i class="fa fa-line-chart"></i>
                    <p>Stats</p>
                  </a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-gavel"></i>
                    <p class="hidden-md hidden-lg">
                      Actions
                      <b class="caret"></b>
                    </p>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Create New Post</a></li>
                    <li><a href="#">Manage Something</a></li>
                    <li><a href="#">Do Nothing</a></li>
                    <li><a href="#">Submit to live</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Another Action</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="notification">5</span>
                    <p class="hidden-md hidden-lg">
                      Notifications
                      <b class="caret"></b>
                    </p>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Notification 1</a></li>
                    <li><a href="#">Notification 2</a></li>
                    <li><a href="#">Notification 3</a></li>
                    <li><a href="#">Notification 4</a></li>
                    <li><a href="#">Another notification</a></li>
                  </ul>
                </li>
                <li class="dropdown dropdown-with-icons">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-list"></i>
                    <p class="hidden-md hidden-lg">
                      More
                      <b class="caret"></b>
                    </p>
                  </a>
                  <ul class="dropdown-menu dropdown-with-icons">
                    <li>
                      <a href="#">
                        <i class="pe-7s-mail"></i> Messages
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="pe-7s-help1"></i> Help Center
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="pe-7s-tools"></i> Settings
                      </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="#">
                        <i class="pe-7s-lock"></i> Lock Screen
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo $URL ?>logout.html" class="text-danger">
                        <i class="pe-7s-close-circle"></i>
                        Log out
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <div class="content">
          <div class="container-fluid">
            <!--
            <div class="menu-back">
              <div class="container">
                <div class="row">
                  
                  <nav class="navbar navbar-default">
                    <div class="container-fluid">
                      
                      <ul class="nav navbar-nav">
                        <li><a href="<?php echo $URL ?>dashboard.html"><i class="fa fa-home"></i> Home</a></li>
                        <?php
                        $dir = getDir();
                        for ($i=0;$i<count($dir);$i++)
                        {
                        if (file_exists($dir[$i]."/index.php"))
                        {
                        if($dir[$i]!="report")
                        include_once $dir[$i]."/index.php";
                        }
                        }
                        ?>
                      </ul>
                    </div>
                  </nav>
                  
                </div>
              </div>
            </div> -->
            
            <?php
            
            if ($DisplayMenu)
            {
            ?>
            <script type="text/javascript">
            $('.changepw').click(function(ev){
            ev.preventDefault();
            $('#changepw').removeData('bs.modal')
            $('#changepw').modal('show');
            });
            </script>
            <?php
            include_once "changepw.php";
            }
            ?>
            <?php
            }
            ?>