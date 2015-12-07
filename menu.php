<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多肽管理系统</title>

<meta name="Keywords" content="多肽管理" />
<meta name="Description" content="多肽管理系统，能实现保密与便捷的统一。" />
<meta name="robots" content="none" />
<meta name="googlebot" content="none" />

<?php 
	include_once("./common/config.php");
	
	//强制清除缓存
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");

	//设置时区为PRC
	date_default_timezone_set('PRC'); 
	
	if(isset($_SESSION['uid'])){
		//超时退出功能
		if((time() - $_SESSION["lastBrowseTime"])<1800){//超时时间为30min=1800s
			$_SESSION["lastBrowseTime"]=time();//更新上次浏览时间
		}else{
			echo "<script>alert('登陆超时，请重新登陆!');
				window.location='action.php?a=logout&r=overTime';
			</script>";
			//header("location:action.php?a=logout&r=overtime");
			exit;
		}
		
		
		//检查是否在其他地方登陆？如果ssession_id不同，则退出当前登陆
		//设置session_id
		$ss=new mySession();
		//echo "last:",$ss->get();
		if( ($ss->get())!=session_id()){
			//
			echo "<script>alert('该用户已经在其他地方登陆。本次登陆已经自动退出...');
					window.location='action.php?a=logout&r=logAtAnotherPlace';
			</script>";
			exit;
		}

	}
	
	//echo "<br />session_id:" . session_id();
?>


<!-- css.css start -->
  <style type="text/css">
* { 
margin: 0; 
padding: 0; 
box-sizing: border-box; 
}
html,body,h1,h2,table,div{margin:0; padding:0;  font-family:"微软雅黑";}
.wrap, .nav{
	width:900px;
	margin:0 auto;
	
	margin-left：auto;
	margin-right：auto;
}


.nav{margin:5px auto; border-bottom:10px solid #0096ff;}
.nav a{padding:5px 10px;}
.nav a:hover{background:#0096ff; color:#fff;}

.right{float:right;}

table.list{border-collapse:collapse;}
table tr td{text-align:center; padding:5px;}
table tr:hover{background:#f5f5f5}

li{list-style:none; border: 1px dotted #785; padding:5px;}
li.odd{ background: #f5f5f5; color:#aaa; border-bottom:none; font-size:12px; }
li.even{margin-bottom:5px; border-top:none; color:#aaa;}
.bold{font-weight:bold; padding:0 10px;}


input{padding:2px; margin:5px;}
.light{color:#ddd;}
.userInfoList{width:500px; margin:0 auto; list-style:none;}
.userInfoList li{padding:5px;}

.red{color:red;}
.black{color:#000;}

	fieldset{width:520px; margin: 0 auto; font-size:12px;}
	legend{font-weight:bold; font-size:14px;}
	label{float:left; width:70px; margin-left:10px;}
	.left{margin-left:80px;}
	.input{width:150px;}
	span{color: #666666;}

  </style>
</head>

<body>
<center>
<h1>多肽管理系统 v0.01</h1>
<p class=light>Contact: fireCloudPHP AT 163 dot com. Based on PHP Version 5.4.4 and MySQL 5.5.25a</p>
<?php
 if(isset($_SESSION["username"])){
 echo "[当前用户: <a href='mycenter.php'>{$_SESSION['username']}</a>  <a href='help.html#usergroup' target='_blank'>({$adminGroup[$_SESSION['usergroup']]})</a> ] : ";
?>
<a href="index.php">浏览信息</a> | 
<a href="add.php">增加记录</a> | 
<a href="mycenter.php">个人中心</a> | 
<a href="javascript:logout();">退出系统</a> | 
<a href="logs.php" title="查看系统日志">系统日志</a> 
<?php
	if($_SESSION['usergroup']>=3){
		echo ' |  <a href="admin.php">用户管理</a>';
	}
}else{ ?>
当前访客身份: 游客 [<a href="login.php">登录</a>|<a href="reg.php">注册]</a> 
  
<?php } 
	echo ' <a href="help.html" target="_blank">[帮助文档]</a>';
?>
<hr />
</center>

<script>
//n秒后跳转到新页面
// Place this in the 'head' section of your page.
function delayURL(url) {
	var delay = document.getElementById("time").innerHTML; //取到id="time"的对象，.innerHTML取到对象的值
	if (delay > 0) {
		delay--;
		document.getElementById("time").innerHTML = delay;
		//delayURL() 就是每间隔1000毫秒 调用delayURL(url);
		setTimeout("delayURL('" + url + "')", 1000);
	} else {
		window.location.href = url; //跳转到URL
	}
}

//退出登陆
function logout(){
	if(confirm("确定要退出吗？")){
		window.top.location.href="action.php?a=logout";
	}
}
//由id返回对象
function $(s){
	if(typeof s=="object"){ return s;}
	return document.getElementById(s);
}


//todo:不知道为什么不能用？因为传递的有一个submit，然后覆盖了form的submit()方法
//替代方案：传递参数submit2
//使用js虚拟表达模拟post元素
function post(URL, PARAMS){
    var temp = document.createElement("form");      
    //temp.id = "mySubmit";      
    temp.action = URL;      
    temp.method = "post";      
    temp.style.visibility="hidden";      
    for (var x in PARAMS) {      
        var opt = document.createElement("input");      
        opt.type = "text";      
        opt.name = x;      
        opt.value = PARAMS[x];      
        // alert(opt.name)      
        temp.appendChild(opt);      
    }      
    document.body.appendChild(temp);      
    temp.submit();      
    return temp;      
}
//调用方法 如      
//temp=post('demo2.php', {'submit':"确认",pid:'1'});

</script>