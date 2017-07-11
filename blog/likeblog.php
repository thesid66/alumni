<?php
	$SQLQuery = $db->query("select * from tblbloglike where BlogID='".$_GET['id']."' and UserID='$txtUserID'");
	if($db->num_rows($SQLQuery)<=0){
		$recID = max_PK("tblbloglike","recID",$db);
        $db->query("insert into tblbloglike set
            recID  = '$recID',
            BlogID  = '".$_SESSION['BlogID']."',
            UserID  = '$txtUserID',
            LikeDate    = '".time()."'
            ");
	}
	else 
	{
		$SQLQuery = $db->query("delete from tblbloglike where BlogID='".$_GET['id']."' and UserID='$txtUserID'");	
	}
	echo "<script>window.location='blogdetail.html'</script>";
	
?>