<?php
//包含数据库连接文件
include('menu.php');


//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['uid'])){
	header("Location:login.php");
	exit();
}



$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$user_query = mysql_query("select * from user where uid=$uid limit 1");
$row = mysql_fetch_array($user_query);
echo '<ul class=userInfoList>';
echo '<h2>用户信息：</h2>';
echo '<li>用户ID：',$uid,'</li>';
echo '<li>用户名：',$username,'</li>';
	//(未审核用户0,注册用户1,管理员2,超级管理员3)
echo '<li>用户组别：',$adminGroup[$row['usergroup']];
if($_SESSION['usergroup']>3){
	echo '  |  <a href="admin.php">用户管理</a>';
}
echo '</li>';

echo '<li>邮箱：',$row['email'],'</li>';
//php,怎样把date("Y-m-d H:i:s ") 
echo '<li>注册日期：',date("Y-m-d H:i:s", $row['regdate']),'</li>';
echo '<li>上次登陆：',date("Y-m-d H:i:s", $_SESSION['lastlogin']),'</li>';
echo '</ul>';
?>