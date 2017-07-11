<?php
	$SQLQuery = $db->query("delete from tblblogcomment where recID='".$_GET['id']."'");
	echo "<script>window.location='blogdetail.html'</script>";
	
?>