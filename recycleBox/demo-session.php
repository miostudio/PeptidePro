<?php
session_start();

include("./bin/function.php");
$ss=new mySession();
$a=$ss->get();
$b=session_id();

echo "<pre>";

echo "a",var_dump($a);
echo 'b',var_dump($b);

if($a==$b){
	echo '同一个登陆';
}else{
	echo "不同的登陆";
}
echo "</pre>";	

		

echo "<hr />";
echo session_id();//umvpe4m8sd9uivvnu9bgfp4qn7
echo "<br>";

echo "<pre>";
//清空session
foreach($_SESSION as $k=>$v){
	//unset($_SESSION[$k]);
}
print_r($_SESSION);
echo "</pre>";

echo time()."<br>";
echo '已经过去',(time() - $_SESSION['lastlogin']), 's<br>';
?>