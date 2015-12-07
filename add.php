<?php
	include("menu.php");
	
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['uid'])){
	header("Location:login.php");
	exit();
}
?>
<style>

</style>

<center>
<h2>增加记录</h2>
<form action="action.php?a=add" method="post" onsubmit="return check(this)" >
<input type="hidden" name=session_id value="<?php echo session_id(); ?>" />
<table style="border-collapse:collapse;border:none;">
	<tr>
		<td>多肽命名</td>
		<td><input type="text" name="peptidename" /></td>
		<td>多肽序列</td>
		<td><input type="text" name="peptideseq" /></td>
	</tr>
	<tr>
		<td>蛋白名称</td>
		<td><input type="text" name="protein" /></td>
		<td>筛选方法</td>
		<td><input type="text" name="method" /></td>
	</tr>
	<tr>
		<td valign="top">备注</td>
		<td colspan="3"><textarea type="text" name="text" style="width:100%;"></textarea></td>
	</tr>
</table>

<input type="submit" name="submit" value="提交" />
<input type="reset" name="reset" value="重置" />

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