<?php
if(!isset($_SESSION['BlogID'])){
	$_SESSION['BlogID']=$_GET['id'];
	echo "<script>window.location='blogdetail.html'</script>";
}

	if(isset($_POST['btnPost']))
	{
	    if($_SESSION['UserDetail']==$_POST['rand'])
	    {
	        $recID = max_PK("tblblogcomment","recID",$db);
	        $db->query("insert into tblblogcomment set
	            recID  = '$recID',
	            BlogID  = '".$_SESSION['BlogID']."',
	            UserID  = '$txtUserID',
	            CommentDate    = '".time()."',
	            Comment    = '".$db->real_escape_string($_POST['txtComment'])."'
	            ");
	    }
	}
$_SESSION['UserDetail'] = randomValue(10);
?>
<div class="row">
	<div class="col-md-12">
		<?php
    		$getPost = $db->query("select * from tblblog where BlogID='".$_SESSION['BlogID']."'");
			$setPost = $db->fetch_object($getPost);
			$BatchYear = $_SESSION['user']['BatchYear'];
		?>
		<div class="card">
			<div class="content">
				<div class="row wall-post">
					<div class="">
						<div class="col-md-2 no-margin">
							<div><img src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($setPost->UserID,$setPost->Gender,$db) ?>" class="img-responsive img-blog" /></div>
						</div>
						<div class="col-md-10">
						<h4 class="no-margin"><a href="<?php echo $URL ?>blog/blogdetail.html?id=<?php echo $setPost->BlogID ?>"><?php echo $setPost->BlogName ?></a></h4>
							<span class="batch-year"><?php echo getUser($setPost->UserID,$db) ?></span>
							<p class="post-prop"><?php echo date("l, M dS, Y \a\\t h:ia",$setPost->BlogDate) ?></p>
							<span>
									<?php 
										$CountLikes = $db->query("select * from tblbloglike where BlogID='".$_SESSION['BlogID']."'");
										echo "<span class='post-prop'>".$db->num_rows($CountLikes)."</span>";
								
										$Query = $db->query("select * from tblbloglike where BlogID='".$_SESSION['BlogID']."' and UserID='$txtUserID'");
										if($db->num_rows($Query)>=1){
									?>
										<a href="likeblog.html?id=<?php echo $setPost->BlogID?>" name="bthLike"><span class="fa fa-heart"></span></a>
									<?php 
									}
									else
										{
									?>
										<a href="likeblog.html?id=<?php echo $setPost->BlogID?>" name="bthLike"><span class="fa fa-heart-o"></span></a>
									<?php
									}		
										if($setPost->UserID==$txtUserID) {
										
									?>
									<a href="delblog.html?id=<?php echo $setPost->BlogID?>" name="bthDelete"><span class="fa fa-trash"></span></a>
									<?php
										}
									?>
								</span>
							<p class="post-prop"><?php echo countComment($setPost->BlogID, $db)?></p>	
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
							<p><?php echo $setPost->BlogDesc?></p>
						</div>									
						</div>
				</div>
			</div>
		</div>
	</div> <!-- end col-md-8 -->
</div>

<div class="row">
	<div class="col-md-12">
	<a style="font-size: 16px;"><strong>Comments</strong></a>
		
		<div class="card">
			<form method="post">
                <div class="content">
                	  <div class="row">
                        <div class="col-sm-11">
                            <textarea class="form-control" name="txtComment" placeholder="Post comment here!" required="true"></textarea>
                        </div>
                        <div class="col-sm-1">
                            <div class="text-center">
                                <button name="btnPost" class="btn btn-primary btn-fill btn-md" >Post</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="rand" value="<?php echo $_SESSION['UserDetail'] ?>">
            </form>
				<?php
		    		$getComment = $db->query("select * from tblblogcomment where BlogID='".$_SESSION['BlogID']."' order by recID desc");
					while($setComment = $db->fetch_object($getComment)){
					$AllDetail = getUserDetail($setPost->UserID,$db);
					$BatchYear = $_SESSION['user']['BatchYear'];
	
				?>
				<div class="comment-box">
					<div class="row wall-post">
						<div class="wall-img"><img src="<?php echo $URL ?>user/profilepicture/<?php echo getUserProfilePic($setComment->UserID,$setComment->Gender,$db) ?>" class="img-responsive img-thumbnail" /></div>
						<div class="wall-desc">
							<a href="<?php echo $URL ?>user/profile.html?id=<?php echo $setComment->UserID ?>"><?php echo getUser($setComment->UserID,$db) ?></a>
							<p class="post-prop"><?php echo date("l, M dS, Y \a\\t h:ia",$setComment->CommentDate) ?> • <?php echo $AllDetail->BatchYear ?> Batch 
								<span>
									<?php 
										if($setComment->UserID==$txtUserID) {
									?>
									<a href="delblogcmnt.html?id=<?php echo $setComment->recID?>" name="bthDelete"><span class="fa fa-trash"></span></a>
									<?php
										}
									?>
								</span>
								</p>
							<p><?php echo $setComment->Comment ?></p>
						</div>
					</div>
				</div>
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</div> <!-- end col-md-8 -->
</div>
