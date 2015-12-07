<?php
//打算建立一个自己的库
//这个做预处理的，是供顶级文件引用的入口文件

//1.定义字符集
header("Content-type: text/html; charset=utf-8");

//2.设置时区
date_default_timezone_set('PRC');
//date_default_timezone_set('Asia/Shanghai');

//3.定义css和js文件夹的上一级位置：
$publicPath='./public/';

//4.定义php类库文件夹
$libPath='D:/xampp/htdocs/PeptidePro/common/';
//$libPath='./common/';

//连接数据库
if(!isset($conn)){
	include( $libPath . 'conn.php');
}

//引入自定义函数库
include( $libPath . 'function.php');