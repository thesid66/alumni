<?php
unset($_SESSION[BlogID]);
	if(isset($_POST['btnPost']))
	{
	    if($_SESSION['UserDetail']==$_POST['rand'])
	    {
	        $BlogID = max_PK("tblblog","BlogID",$db);
	        $db->query("insert into tblblog set
	            BlogID  = '$BlogID',
	            UserID  = '$txtUserID',
	            BlogDate    = '".time()."',
	            BlogType    = '".$db->real_escape_string($_POST['txtBlogType'])."',
	            BlogName    = '".$db->real_escape_string($_POST['txtBlogTitle'])."',
	            BlogDesc    = '".$db->real_escape_string($_POST['txtBlogDesc'])."',
	            Type = '1'
	            ");
	    }
	}
$_SESSION['UserDetail'] = randomValue(10);
?>
<div class="row">
		<div class="col-md-12">
			<!-- Button trigger modal -->
			<a class="pull-right btn btn-primary btn-fill btn-sm" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus"></span> Add New Job</a>
			<hr>
		</div>
	</div>
<div class="row">
	<div class="col-md-12">
		<?php
    		$getPost = $db->query("select * from tblblog where Type='1' order by BlogID desc");
			while ($setPost = $db->fetch_object($getPost)) {
			$BatchYear = $_SESSION['user']['BatchYear'];
		?>
			<div class="col-xs-6">
				<div class="card">
					<div class="content">
						<div class="row wall-post">
							<div class="wall-desc">
								<a href="<?php echo $URL ?>job/jobdetail.html?id=<?php echo $setPost->BlogID ?>"><?php echo $setPost->BlogName ?></a><br>
									<span class="batch-year"><?php echo getUser($setPost->UserID,$db) ?></span>
									<p class="post-prop"><?php echo date("l, M dS, Y \a\\t h:ia",$setPost->BlogDate) ?></p>
									<p class="post-prop"><a href="<?php echo $URL ?>job/jobdetail.html?id=<?php echo $setPost->BlogID ?>" class="btn btn-primary btn-xs">Read More..</a> <span><?php echo countComment($setPost->BlogID,$db)?></span></p>
									
								</div>
						</div>
					</div>
				</div>
			</div>
		<?php
			}
		?>
	</div> <!-- end col-md-8 -->
</div>
<!-- Modal Starts-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="card">
            <div class="content-header">
                <p>Add New Job & Opportunities</p>
            </div>
            <form method="post">
                <div class="content">
                	<div class="row">
                        <div class="col-sm-12">
                        	<input type="text" class="form-control" name="txtBlogTitle" placeholder="Add title here!">
                        </div>
                    </div></br>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="txtBlogDesc" placeholder="Add detail here!"></textarea>
                        </div>
                    </div>
                    <div class="row content-button-div">
                        <div class="col-sm-12">
                            <div class="pull-left">
                                <select name="txtBlogType" class="form-control">
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
  </div>
</div><!-- Modal Ends-->