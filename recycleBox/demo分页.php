<?php
$itemPerPage=5;//设置每页记录条数

//获取记录总数
include("./bin/conn.php");
$execc="select count(*) from logs"; 
$rows=mysql_query($execc); 
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
	$result=mysql_query("select * from logs limit ".(($page-1)*$itemPerPage).",{$itemPerPage}");
	//循环输出结果记录
	echo "<pre>";
	while($rs=mysql_fetch_object($result)){ 
		var_dump($rs->lid); 
		//echo "pid=".$rs->lid."<br />"; 
	} 
	echo "</pre>";
?>
<div class=nav>
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page=1';?>">首页</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page-1);?>">前一页</a> | 
	<a >第<?=($page)?>页</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page+1);?>">后一页</a> | 
	<a href="<?php echo $_SERVER['PHP_SELF'].'?page='.$totlePages;?>">尾页</a> 

</div>