﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>

<script language=JavaScript>
<!--

function InputCheck(RegForm){
  if (RegForm.username.value == ""){
    alert("用户名不可为空!");
    RegForm.username.focus();
    return (false);
  }
  if (RegForm.password.value == ""){
    alert("必须设定登陆密码!");
    RegForm.password.focus();
    return (false);
  }
  
  //判断密码长度
   if (RegForm.password.value.length < 6){
    alert("密码至少6位!");
    RegForm.password.focus();
    return (false);
  }
  if (RegForm.repass.value != RegForm.password.value){
    alert("两次密码不一致!");
    RegForm.repass.focus();
    return (false);
  }
  if (RegForm.email.value == ""){
    alert("电子邮箱不可为空!");
    RegForm.email.focus();
    return (false);
  }
}


//my js：重定向到登陆页
function $(s){return document.getElementById(s);}
window.onload=function(){
	$("login").onclick=function(){
		window.location.href="login.php";
	}
}
//-->
</script>
</head>


<body>
<?php include("menu.php");?>
<div>
<fieldset>
	<legend>用户注册</legend>
	<form name="RegForm" method="post" action="action.php?a=reg" onSubmit="return InputCheck(this)">
		<p>
			<label for="username" class="label">用户名:</label>
			<input id="username" name="username" type="text" class="input" />
			<span>(必填，3-15字符长度，支持汉字、字母、数字及_)</span>
		<p/>
		<p>
			<label for="password" class="label">密 码:</label>
			<input id="password" name="password" type="password" class="input" />
			<span>(必填，不得少于6位)</span>
		<p/>
		<p>
			<label for="repass" class="label">重复密码:</label>
			<input id="repass" name="repass" type="password" class="input" />
		<p/>
		<p>
			<label for="email" class="label">电子邮箱:</label>
			<input id="email" name="email" type="text" class="input" />
			<span>(必填)</span>
		<p/>
		<p>
			<input type="submit" name="submit" value="  提交注册  " class="left" />
			<input type="button" id="login" value="  登陆  " class="right" />
		</p>
	</form>
</fieldset>
</div>
</body>
</html>