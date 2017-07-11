<?php
	$SQLQuery = $db->query("delete from tblblogcomment where BlogID='".$_GET['id']."'");
	$SQLQuery = $db->query("delete from tblblog where BlogID='".$_GET['id']."'");
	echo "<script>window.location='blog.html'</script>";
	
?>