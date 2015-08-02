<?php
//session_start();
include('menu.php');
include_once('./bin/function.php');

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['usergroup'])){
	header("Location:login.php");
	exit();
}elseif($_SESSION['usergroup']<4){
	die("<center><p class=red>您无权查看该页面!</p>请返回 <a href='mycenter.php'> 用户中心</a></center>");
}

//包含数据库连接文件
include_once('./bin/conn.php');

$rs = mysql_query("select * from user order by uid");
echo '<div class=wrap>';
echo '<h2>用户权限列表：</h2>';
echo '<table border="1" class="list" >';
echo "<tr><th>用户id</th><th>用户名</th><th>用户组别</th><th>注册时间</th><th>操作</th></tr>";
while($row = mysql_fetch_array($rs)){
	$id=$row['uid'];
	echo "<tr><td>{$id}</td><td>{$row['username']}</td><td>",$adminGroup[$row['usergroup']],"</td><td>".date('Y-m-d H:i:s', $row['regdate'])."</td>";
	echo '<td>
		<a href="adminAct.php?a=lock&id='.$id.'">锁定用户</a> | 
		<a href="adminAct.php?a=del&id='.$id.'">删除用户</a> | 
		<a href="adminAct.php?a=chpsw&id='.$id.'">修改密码</a> | 
		<a href="adminAct.php?a=chgrp&id='.$id.'">修改分组</a></td>';	
	echo '</tr>';
	//(锁定用户0, 未审核用户1,注册用户2,管理员3,超级管理员4)
}
echo '</table>';
echo '</div>';
?>