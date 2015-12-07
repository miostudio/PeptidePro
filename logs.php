<?php
include("menu.php");


 echo '<div class=wrap>';


//如果没有登陆，则提示登陆；
if(!isset($_SESSION["username"])){
	die("<center><p class=red>未登录用户没有访问权限！</p>请先 <a href='login.php'>登陆</a> 系统。</center>");
}

	echo "<h2>系统日志 <span class=light> 最新操作 </span></h2>";


//设置每页记录条数,放到了配置文件中
//$itemPerPage=5;

//获取记录总数
$rows=mysql_query("select count(*) from logs"); 
$num=mysql_fetch_array($rows)[0]; 
 
//总的页数 
$totlePages = ceil($num/$itemPerPage); 


//获取页码并显示
if(empty($_GET['page'])){ 
	$page=1; 
}else{ 
	$page=$_GET['page']; 
	//人为让page从1计数（php默认从0计数的） 
	//显示给用户的url和按钮，从1开始计数；
	//对php传递参数从0计数；
	if($page<=1)$page=1; 
	if($page>=$totlePages) $page=$totlePages;
}



//获取一页的若干条记录 
$logs_query=mysql_query('select * from logs order by logdate desc limit '.(($page-1)*$itemPerPage).",{$itemPerPage}");

?>

<div class=nav>
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page=1';?>">最新</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page-1);?>">新一点</a> | 
	<a >第<?=($page)?>页</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page+1);?>">旧一点</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.$totlePages;?>">最旧</a> 
</div>

<?php

//表头
echo "<li>日志id | 用户名 | 操作 | 日志时间 | 日志备注</li><hr/>";
//内容
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
