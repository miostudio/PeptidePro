<?php
	include_once("./common/config.php");
//删除条目
if(isset($_GET['pid'])){
	$pid=$_GET['pid'];
	//删除数据

	// delete from user where uid=3;
	$sql = "delete from peptide where pid=".$pid.";";
	$rs = mysql_query($sql);
	if(mysql_affected_rows()>0){
		//记录到数据库
		doLogs(4,"原作者: ");
		echo "删除成功！<a href='index.php'>首页</a>";
		exit;
	}else{
		echo "删除失败！<a href='index.php'>首页</a>";
		exit;
	}
}
?>