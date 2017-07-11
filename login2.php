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
		$fy = $db->real_escape_string($_POST['txtFY']);

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
				$txtError = "<span class='fa fa-warning fa-2x'></span> Email and Password didn't match";
		}
		if ($isAuthenticated)
		{
				$username = $row->Username;
				$name= $row->FullName;
				$pass = $row->password;
				$txtUserID = $row->UserID;
				$Status = $row->Status;
				$UserType = $row->UserType;
				$LastLogin = $row->LoginTime;
				$DistrictCode = $row->DistrictCode;
				
				
				if ($Status != "0")	//if not active a/c
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
					$_SESSION['user']['fullname'] = $row->FullName;
					$_SESSION['user']['fy'] = $fy;
					$_SESSION['user']['UserType'] = $UserType;
					$_SESSION['user']['DistrictCode'] = $DistrictCode;
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
													notify("Welcome","<b>Welcome to the Statistical Information Software</b>", 
													$URL ."dashboard.html", FALSE,2000);
													
													?>
													</div>
												</div>
										 
									<?php 
									include_once "footer.inc.php";
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
<div class="" style="width:auto; right:10px; overflow:visible; position:absolute">
<div class="alert alert-warning alert-dismissable" id="alert">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo "<b>$txtError</b>";?>
</div>
</div>
<?php } ?>
       <br />
            <div class="module-login col-sm-4 col-sm-offset-4">
            <form class="form-vertical" method="post">
            <div class="panel panel-primary">
                    
                    <div class="panel-heading">
							<h3 class="panel-title">Sign In</h3>
						</div>
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
                    <div class="panel-body">
                    	<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            <input class="form-control" autofocus="autofocus" type="text" name="txtUser" id="inputEmail" placeholder="Username">
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-lock"></span></span>
                            <input class="form-control" type="password" name="txtPass" id="inputPassword" placeholder="Password">
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span>FY</span></span>
                            <select name="txtFY" id="txtFY" class="form-control">
                            	<?php
								$getFY = $db->query("select * from tblfiscalyear order by fy desc");
								while($setFY=$db->fetch_object($getFY))
								{
								?>
                                	<option value="<?php echo $setFY->fy ?>"><?php echo $setFY->fy ?></option>
                                <?php
								}
								?>
                            </select>
                            
                        </div>
                        </div>
                        
                    </div>
                    <div class="panel-footer">
							<div class="control-group">
								<div class="controls clearfix">
                                <input type="hidden" name="rand" value="<?php echo $rand;?>">
									<button type="submit" class="btn btn-primary pull-right" name="btnLogin"><span class="fa fa-sign-in"></span> Login</button>
									
								</div>
							</div>
                </div>
                 
    
    
            </div></form>
           </div>
            
        
<?php

$db->close();
?>