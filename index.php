<?php
include("menu.php");

//如果没有登陆，则提示登陆；
if(!isset($_SESSION["username"])){
	die("<center><p class=red>未登录用户没有访问权限！</p>请先 <a href='login.php'>登陆</a> 系统。</center>");
}

//如果登陆成功，则根据用户权限，显示相应条目
include("./bin/conn.php");
//sql语句
$rs = mysql_query("select * from peptide order by submitdate", $conn);

//开始显示
echo "<div class=wrap id=wrap>";
echo "<h2>多肽信息列表</h2><hr/>";
while($result = mysql_fetch_array($rs)){
	//登录成功
	$pid = $result['pid'];
	$username = getUserNameById($result['uid']);
	$peptidename = $result['peptidename'];
	$peptideseq = $result['peptideseq'];
	$protein = $result['protein'];
	$method = $result['method'];
	$submitdate = date("Y-m-d H:i:s", $result['submitdate']);
	$modifydate = date("Y-m-d H:i:s", $result['modifydate']);
	$note = $result['note'];;
	
	if($_SESSION['usergroup']<2 and ($_SESSION['uid']!=$result['uid'])){
		continue;
	}
	if($submitdate!=$modifydate){
		$modiInfo=" | 最近修改 {$modifydate}";
	}else{
		$modiInfo="";
	}
	echo "<li class=odd>$username | 提交于 {$submitdate} {$modiInfo}";
if(($_SESSION["usergroup"]>=3) or ($result['uid']==$_SESSION["uid"]) ){
	$session_id=session_id();
	echo "<script>session_id='{$session_id}'</script>";
	echo " <span class=right><a href='edit.php?&pid=".$pid."'>修改</a> | " . 
	"<a href='javascript:void(0);' onclick='deleteItem({$pid})'>删除</a></span>";
}
	echo "</li>";
	echo "<li class=even>[{$peptidename} 肽:<a class='bold black'>{$peptideseq}</a>], 靶蛋白:{$protein}, 筛选方法:{$method}. 备注信息:{$note}</li>";
}
//action.php?a=del&pid=".$pid."

echo "</div>";
?>

<script>
//删除条目
function deleteItem(pid){
	if(confirm("确认要删除id="+pid+"的多肽吗?")){
		post('action.php', {'submit2':"确认",'pid':pid, "session_id":session_id});
	}
}

</script>