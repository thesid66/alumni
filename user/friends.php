<?php
	if(isset($_POST['btnPost']))
	{
    if($_SESSION['UserDetail']==$_POST['rand'])
    {
      $recID = max_PK("tblmessage","recID",$db);
      $db->query("insert into tblmessage set
        recID  = '$recID',
        SenderID  = '$txtUserID',
				ReceiverID    = '".$db->real_escape_string($_POST['receiver'])."',
        MessageDate    = '".time()."',
        Message    = '".$db->real_escape_string($_POST['txtMessage'])."'
        ");
      success_alert();
    }
	}
	$_SESSION['UserDetail'] = randomValue(10);
?>
<div class="row">
	<div class="col-md-12">
	    <div class="nav-container">
	        <ul class="nav nav-icons">
	            <li class="active">
	                <a href="#" id="0" class="batch-tab">
	                    <i class="fa fa-users "></i><br>
	                    <strong>All Friends</strong>
	                </a>
	            </li>
	            <li>
	                <a href="#" id="<?php echo $BatchYear?>" class="batch-tab">
	                    <i class="fa fa-graduation-cap"></i><br>
	                    <strong>Batch Friends</strong>
	                </a>
	            </li>
	        </ul>
	    </div>

	    <div class="active">
	      <div class="tab-pane">
		      <?php
		        $getData = $db->query("select * from tbluser order by FirstName asc");
						while ($setData = $db->fetch_object($getData)) {
					?>
					<div class="col-xs-4 friend <?php echo $setData->BatchYear?>">
						<div class="card">
							<div class="content">
								<div class="row wall-post">
									<div class="col-xs-4 no-margin">
										<div class="img-responsive"><img src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($setData->UserID,$setData->Gender,$db) ?>" class="img-responsive img-thumbnail" /></div>
									</div>	
									<div class="col-xs-8 no-margin">
										<div class="wall-desc">
											<a href="<?php echo $URL ?>user/profile.html?id=<?php echo $setData->UserID ?>"><?php echo getUser($setData->UserID,$db) ?></a> </br>
											<span class="batch-year"><?php echo $setData->City.", ".getCountry($setData->Country,$db) ?></span>
											<p class="post-prop"><?php echo $setData->BatchYear ?> Batch</p>
											<p><?php echo $setData->PostDesc ?></p>
											<?php
												if($setData->UserID!=$txtUserID)
												{
											?>
											<a class="btn btn-round btn-xs btn-primary send-message" data-toggle="modal" data-target="#myModal" data-userid="<?php echo $setData->UserID;?>"><span class="fa fa-location-arrow"></span> Send Message</a>
											<?php
												}
												else 
												{
											?>
											<a class="btn btn-round btn-xs btn-danger"><span class="fa fa-user-circle"></span> View Profile</a>
											<?php		
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>
	    	</div>
	    </div> <!-- end tab content -->
	</div> <!-- end col-md-8 -->
</div>

<!-- Modal Starts-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="card">
            <div class="content-header">
                <p>Send Message</p>
            </div>
            <form method="post">
                <div class="content">
                	  <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="txtMessage" placeholder="Type message here!"></textarea>
                        </div>
                    </div>
                    <div class="row content-button-div">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button name="btnPost" class="btn btn-primary btn-fill btn-wd" >Send</button>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="rand" value="<?php echo $_SESSION['UserDetail'] ?>">
                <input type="hidden" readonly="true" name="receiver" id="receiver">
            </form>
        </div>
  </div>
</div><!-- Modal Ends-->

<script>
	$(document).ready(function() {
		$('.batch-tab').click(function(event) {
			batch_id= $(this).attr('id');
			if(batch_id==0) {
				$('.friend').show();
				$('.nav-icons li').removeClass('active');
				$(this).parent('li').addClass('active');
			}
			else {
				$('.friend').hide();
				$('.'+batch_id).show();	
				$('.nav-icons li').removeClass('active');
				$(this).parent('li').addClass('active');
			}
			return false;
		});
		$('.send-message').click(function(event) {
			user_id=$(this).data("userid");
			$('#receiver').val(user_id);
		});
	});

</script>