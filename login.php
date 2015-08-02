<?php
include("menu.php");

echo "<center>";

if(isset($_SESSION["username"])){
	echo "您已经登录！用户名为：{$_SESSION['username']}";
?>

<span id="time" class="red">5</span>秒钟后自动跳转，如果不跳转，请点击下面链接<br />
<a href="index.php">首页</a>
<script type="text/javascript">
    delayURL(<?php echo "'index.php'"; ?>); //延迟跳转
</script>

<?php
exit;

}else{
?>
<form action="action.php?a=login" method="post" onsubmit="return InputCheck(this)">
	用户名：<input type=text name=username /><br />
	密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type=password name=password /><br />
	<input type=submit name=submit value="确认" /> 
	<input type=reset name=reset value="重置" /><br />
	<a href="reg.php" title="仅限内部人员使用，请实名注册！">注册</a>
</form>
<?php
}
echo "</center>";
?>

<script language=JavaScript>
<!--
function InputCheck(RegForm){
  if (RegForm.username.value == ""){
    alert("用户名不可为空!");
    RegForm.username.focus();
    return (false);
  }
  if (RegForm.password.value == ""){
    alert("请填写登陆密码!");
    RegForm.password.focus();
    return (false);
  }
  
  //判断密码长度
   if (RegForm.password.value.length < 6){
    alert("密码至少6位!");
    RegForm.password.focus();
    return (false);
  }
}
-->
</script>
