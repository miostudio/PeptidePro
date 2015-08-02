<?php
include("menu.php");
include_once("./bin/conn.php");
include_once("./bin/function.php");

?>

<div class=wrap>

<?php
//如果没有登陆，则提示登陆；
if(!isset($_SESSION["username"])){
	die("<center><p class=red>未登录用户没有访问权限！</p>请先 <a href='login.php'>登陆</a> 系统。</center>");
}

	echo "<h2>系统日志 <span class=light>[仅显示最新操作]</span></h2>";

//包含数据库连接文件
include('./bin/conn.php');
//检测用户名及密码是否正确
$logs_query = mysql_query("select * from logs order by logdate desc", $conn);
echo "<li>日志id | 用户名 | 操作 | 日志时间 | 日志备注</li><hr/>";
while($result = mysql_fetch_array($logs_query)){
	//登录成功
	$lid = $result['lid'];
	$username = getUserNameById($result['uid']);
	$action = $logAction[$result['action']];
	$logdate = date("Y-m-d H:i:s", $result['logdate']);
	$lognote = $result['lognote'];;

	echo "<li>{$lid} | {$username} | {$action} | {$logdate} | {$lognote}</li>";
}

?>

</div>