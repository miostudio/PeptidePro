<?php
//这是后台操作处理的页面，没有可显示内容；
session_start();

include("./common/config.php");

//注销登录
if(!empty($_GET['a'])){
	if($_GET['a'] == "logout"){
		//记录日志：退出事件
		if(isset($_GET['r'])){
			$r=$_GET['r'];
			doLogs(2,"自动退出.原因：".$r);
		}else{
			doLogs(2);
		}
		
		//清空session
		foreach($_SESSION as $k=>$v){
			unset($_SESSION[$k]);
		}

		/*
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		unset($_SESSION['lastlogin']);
		unset($_SESSION['usergroup']);*/
		echo '注销登录成功！点击此处 <a href="login.php">登录</a>';
		header("location:login.php");
		exit;
	}
}

//处理删除帖子的请求
if(isset($_POST["submit2"]) and isset($_POST["pid"]) ){
	//获得数据
	$session_id =$_POST["session_id"];
	if($session_id!=session_id()){
		die("非法提交！返回<a href='index.php'>首页</a>");
	}
	
	$pid=$_POST["pid"];
	$peptidename=getPeptideNameByPid($pid);
	$oriUid=getUserNameById( getUidByPid($pid) );
	
	//写入数据库
	$sql = " delete from peptide where pid={$pid};";
	$rs = mysql_query($sql);
	
	//获得反馈
	if(mysql_affected_rows()>0){
		echo "删除记录成功！";
		//记录日志
		doLogs(4,"多肽名字:{$peptidename}. 原作者:{$oriUid}");
		echo '<script>alert("删除成功！正在跳转到主页...") </script>';
		header("location:index.php");
		exit;
	}else{
		echo '抱歉！删除数据失败：',mysql_error(),'<br />';
		echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		exit;
	}
}


//除了注销，其他都要post传输，否则定义为非法登录
if(!isset($_POST["submit"]) or !isset($_GET["a"]) ){
	echo "非法登录!返回<a href='index.php'>首页</a>";
	exit;
}

//处理登陆、注册、查询等操作
switch ($_GET['a']){
	case "login":
		//echo "this is login";
		//替换特殊字符为html实体
		$username = htmlspecialchars($_POST['username']);
		//对密码加密
		$password = MD5($_POST['password']);

		//检测用户名及密码是否正确
		$check_query = mysql_query("select * from user where username='$username' and password='$password' limit 1");
		if($result = mysql_fetch_array($check_query)){
			//登录成功
			$_SESSION['uid'] = $result['uid'];
			$_SESSION['username'] = $username;
			$_SESSION['lastlogin'] = $result['lastlogin'];
			$_SESSION['usergroup'] = $result['usergroup'];
			
			
			//设置session_id
			$ss=new mySession();
			$ss->set();
			

			//更新该用户的登陆时间
			updateLastLgin($result['uid']);
			//记录日志：登陆事件
			doLogs(1);
			$_SESSION["lastBrowseTime"]=time();
			
			echo "<script>alert('{$username} 登陆成功!');</script>";
			echo "<script>window.location.href='index.php'</script>";
			exit;
		} else {
			exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
		}
		break;
	case "reg":
		//echo "this is reg";
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		//注册信息判断
		if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $username)){
			exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
		}
		if(strlen($password) < 6){
			exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
		}
		if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
			exit('错误：电子邮箱格式错误。<a href="javascript:history.back(-1);">返回</a>');
		}

		//检测用户名是否已经存在
		$check_query = mysql_query("select uid from user where username='$username' limit 1");
		if(mysql_fetch_array($check_query)){
			echo '错误：用户名 ',$username,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
			exit;
		}
		//写入数据
		$password = MD5($password);
		$regdate = time();
		$usergroup=1;//默认用户组为1，只能查看自己的数据
		$sql = "INSERT INTO user(username,password,email,regdate,lastlogin,usergroup)VALUES('$username','$password','$email',$regdate,$regdate,$usergroup)";
		if(mysql_query($sql,$conn)){
			//改写session
			$rs = mysql_query("select * from user where username='$username' and password='$password' limit 1");
			if($result = mysql_fetch_array($rs)){
				//登录成功
				$_SESSION['uid'] = $result['uid'];
				$_SESSION['username'] = $username;
				$_SESSION['lastlogin'] = $result['lastlogin'];
				$_SESSION['usergroup'] = $result['usergroup'];
			}
			
			//写入日志
			doLogs(0);
			echo '用户注册成功！返回 <a href="index.php">首页</a>';
			header("location:index.php");
			exit;
		} else {
			echo '抱歉！添加数据失败：',mysql_error(),'<br />';
			echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		}
		break;
	case "add":
		//echo "this is add";
		//获得数据
		$session_id =$_POST["session_id"];
		if($session_id!=session_id()){
			die("非法提交！返回<a href='index.php'>首页</a>");
		}
		
		$peptidename=$_POST["peptidename"];
		$peptideseq=$_POST["peptideseq"];
		
		$protein=$_POST["protein"];
		$method=$_POST["method"];
		$note=$_POST["text"];
		
		$submitdate=time();

		//写入数据库
		$sql = "INSERT INTO peptide(uid,peptidename,peptideseq,protein,method,submitdate,modifydate,note)VALUES({$_SESSION['uid']},'$peptidename','$peptideseq','$protein','$method','$submitdate','$submitdate','$note')";
		//TODO
		$rs = mysql_query($sql);
		
		//获得反馈
		if(mysql_affected_rows()>0){
			echo "增加记录成功！";
			//记录
			doLogs(3,"多肽名字:{$peptidename}");
			header("location:index.php");
			exit;
		}else{
			echo '抱歉！添加数据失败：',mysql_error(),'<br />';
			echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		}
		break;
	case "update":
		//echo "this is update";
		//获得数据
		$session_id =$_POST["session_id"];
		if($session_id!=session_id()){
			die("非法提交！返回<a href='index.php'>首页</a>");
		}
		
		$pid=$_POST["pid"];
		
		$peptidename=$_POST["peptidename"];
		$peptideseq=$_POST["peptideseq"];
		
		$protein=$_POST["protein"];
		$method=$_POST["method"];
		$note=$_POST["text"];
		
		$modifydate=time();

		//写入数据库
		$sql = "update  peptide set peptidename='$peptidename', peptideseq='$peptideseq', protein='$protein', method='$method' ,modifydate=$modifydate, note='$note' where pid='$pid'";
		//TODO:
		$rs = mysql_query($sql);
		
		//获得反馈
		if(mysql_affected_rows()>0){
			echo "增加记录成功！";
			//记录
			$oriUid=getUserNameById( getUidByPid($pid) );
			doLogs(8,"多肽名字:{$peptidename}. 原作者 {$oriUid}");
			echo '<script>alert("修改成功！正在跳转到主页...") </script>';
			header("location:index.php");
			exit;
		}else{
			echo '抱歉！添加数据失败：',mysql_error(),'<br />';
			echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
			exit;
		}
		break;
	default:
		die("非法提交！返回<a href='index.php'>首页</a>");
}
?>