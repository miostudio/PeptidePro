<?php
session_start();

//include_once("menu.php");

/*

$_SESSION["name"]="wjl";
$_SESSION["adminGroup"]="3";

//unset($_SESSION["name"]);

echo "session_id: ",session_id(),"<hr>";


//确定是否显示删除按钮
if(isset($_SESSION["adminGroup"])){
	if($_SESSION["adminGroup"]==3){
		echo "<a href=".$_SERVER["PHP_SELF"]."?a=del&tid=2>删除</a>";
	}
}

//是否删除
if(isset($_GET["tid"])){
	echo $_GET["tid"];
}

*/

/***/
echo "<pre>";
print_r($_POST);
echo "<hr>";
print_r($_GET);
echo "</pre>";
?>

<script>

//todo:不知道为什么不能用？
//使用js虚拟表达模拟post元素
function post(URL, PARAMS){
    var temp = document.createElement("form");      
    temp.action = URL;      
    temp.method = "post";      
    temp.style.display = "none";      
    for (var x in PARAMS) {      
        var opt = document.createElement("textarea");      
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
//post('demo2.php', {submit:"确认",cm1:'sdsddsd',cm2:'haha'});

</script>
