<?php
//这是函数库和常量定义

//设置每页记录条数,
$itemPerPage=50;

//定义用户权限
$adminGroup=array(0=>"锁定用户",1=>"未审核用户",2=>"注册用户",3=>"管理员",4=>"超级管理员",);

//定义日志操作类型
$logAction=array(
	 0=> "注册",
	 1=> "登陆",
	 2=> "退出",
	 3=> "增加记录",
	 4=> "删除记录",
	 5=> "授权",
	 6=> "取消授权",
	 7=> "重置密码",
	 8=> "修改记录",
	 9=> "其他行为",
);

/**
日志函数：根据传入参数，记录操作者的主要行为(定义在function.php文件中)
*/
function doLogs($action,$lognote=" "){
	$uid=$_SESSION["uid"];
	$logdate=time();
	//执行数据库
	$sql="insert into logs(uid,action,logdate,lognote) values({$uid},{$action},{$logdate},'{$lognote}');";

	$logsInsert = mysql_query($sql);
}

 /**
根据uid更新用户登陆时间为当前时间
 */
function updateLastLgin($uid){
	//包含数据库连接文件

	//获取时间
	$newTime=time();
	//执行更新
	$query = mysql_query("update user set lastlogin={$newTime} where uid={$uid};");
	if(mysql_affected_rows()>0){
		return true;
	}else{
		return false;
	}
}

/**
由用户id得到用户名
*/
function getUserNameById($uid){
	$check_query = mysql_query("select username from user where uid={$uid} limit 1");
	if($result = mysql_fetch_array($check_query)){
		return $result["username"];
	}
	return null;
}




/**
由pid得到peptidename
*/
function getPeptideNameByPid($pid){
	$check_query = mysql_query("select peptidename from peptide where pid={$pid} limit 1");
	if($result = mysql_fetch_array($check_query)){
		return $result["peptidename"];
	}
	return null;
}


/**
由pid得到uid
*/
function getUidByPid($pid){
	$check_query = mysql_query("select uid from peptide where pid={$pid} limit 1");
	if($result = mysql_fetch_array($check_query)){
		return $result["uid"];
	}
	return null;
}

/**mySession类
功能：更新与获得session_id。防止用户同时登陆多个进程。
*/
class mySession{
	function get(){
		$uid=$_SESSION["uid"];

		$check_query = mysql_query("select session_id from user where uid={$uid} limit 1");
		if($result = mysql_fetch_array($check_query)){
			return $result["session_id"];
		}else{
			echo "读取失败. ",mysql_error(),"<hr>";
		}
		return session_id;
	}
	
	function set(){
		$uid=$_SESSION["uid"];
		
		$session_id=session_id();
		//update user set usergroup=4 where uid=1;
		$check_query = mysql_query("update user set session_id='{$session_id}' where uid={$uid}");
		if(!mysql_error()){
			return true;
		}else{
			echo "写入失败. ",mysql_error(),"<hr>";
			return false;
		}
	}
}


?>