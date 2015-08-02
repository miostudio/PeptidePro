<?php
/*****************************
*数据库连接
*****************************/
//页面字符集
//header("content-type:text/html; cahrset=utf-8");

#1、获取连接
//加@是为了忽略错误；
$conn = @mysql_connect("localhost","root","");
if (!$conn){
	die("连接数据库失败：" . mysql_error());
}
#2、选择数据库
mysql_select_db("WJLiBBS", $conn);
#3、设置操作编码(建议有):校对一致
//字符转换，读库
mysql_query("set character set 'utf8'");
//写库
mysql_query("set names 'utf8'");
?>