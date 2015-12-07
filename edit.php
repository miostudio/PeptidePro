<?php
	include("menu.php");
	
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['uid'])){
	header("Location:login.php");
	exit();
}

echo "<center>";

//如果没有指明修改的多肽id，则报错
if(!isset($_GET['pid'])){
	die("没有指定要修改的多肽的id!  返回 <a href='index.php'>首页</a>");
}

//获得pid
$pid=$_GET['pid'];
//由pid获得uid
//引入自定义函数 at menu.php
$oriUid=getUidByPid($pid);
if($oriUid==null){
	die("没有找到该肽的提交者！返回 <a href='index.php'>首页</a>");
}

//如果不是自己的肽 或者不是管理员，则报错！
if($_SESSION["uid"]!=$oriUid){
	if($_SESSION["usergroup"]<=2){
		die("您没有权限修改该信息！返回 <a href='index.php'>首页</a>");
	}	
}


//获取多肽信息
$rs = mysql_query("select * from peptide where pid={$pid} limit 1");
$row = mysql_fetch_array($rs);
if(!$row){
	die("拉取多肽信息失败！返回 <a href='index.php'>首页</a>");
}

?>
<h2>修改记录</h2>
<form action="action.php?a=update" method="post" onsubmit="return check(this)" >
<input type="hidden" name=session_id value="<?php echo session_id(); ?>" />
<input type="hidden" name="pid" value="<?php echo $row['pid']?>" />
<table style="border-collapse:collapse;border:none;">
	<tr>
		<td>多肽命名</td>
		<td><input type="text" name="peptidename" value="<?php echo $row['peptidename']?>" /></td>
		<td>多肽序列</td>
		<td><input type="text" name="peptideseq"  value="<?php echo $row['peptideseq']?>" /></td>
	</tr>
	<tr>
		<td>蛋白名称</td>
		<td><input type="text" name="protein"  value="<?php echo $row['protein']?>" /></td>
		<td>筛选方法</td>
		<td><input type="text" name="method"  value="<?php echo $row['method']?>" /></td>
	</tr>
	<tr>
		<td valign="top">备注</td>
		<td colspan="3"><textarea type="text" name="text" style="width:100%;"><?php echo $row['note']?></textarea></td>
	</tr>
</table>

<input type="submit" name="submit" value="提交" />
<input type="button" name="cancel" onclick="location.href='index.php'" value="取消" />

</form>
</center>

<script>
//除去空格
function trim(str){ //删除左右两端的空格
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){ //删除左边的空格
	return str.replace(/(^\s*)/g,"");
}
function rtrim(str){ //删除右边的空格
	return str.replace(/(\s*$)/g,"");
}

function check(form){
	var peptidename=form.peptidename.value;
	var peptideseq=form.peptideseq.value;
	var protein=form.protein.value;
	var method=form.method.value;
	var text=form.text.value;
	
	if(trim(peptidename).length<1){
		alert("多肽名字不能为空！");
		return false;
	}
	if(trim(peptideseq).length<1){
		alert("多肽序列不能为空！");
		return false;
	}
	
	if(trim(protein).length<1){
		alert("蛋白名字不能为空！");
		return false;
	}
	if(trim(method).length<1){
		alert("筛选方法不能为空！");
		return false;
	}
	
	return true;
}
</script>