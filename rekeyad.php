<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>证券/资金账户管理</title>
<link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap.css"></head>
<link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap-theme.css"  />
<link rel="stylesheet" href="style/bootstrap_combined.css" />
<link rel="stylesheet" href="style/layout.css"  />
<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap-3.3.4-dist/js/bootstrap.js"></script>
<script type="text/javascript" src="bootstrap-3.3.4-dist/js/npm.js"></script>
</head>

<body>
<?php
	include 'config.php';
	$password1 = $_POST['password'];
	$password2 = $_POST['repassword'];
	$id = $_POST['id'];
	$expassword = $_POST['expassword'];
	if(!$password1 || !$password2 || !$id || !$expassword)
	{
		echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=re_key_ad.html");
		exit();
	}
	
	
	
	$con = new mysqli($url,$user,$pwd,$db);
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$sql1 = "select * from account where account_id = '".$id."'";
	$res1 = mysqli_query($con,$sql1);
	$newArray = mysqli_fetch_array($res1, MYSQLI_ASSOC);
	if(!$newArray)
	{
		echo"<p><center>未查寻到该账户</center></p>";
		header("refresh:1;url=re_key_ad.html");
		exit();
	}
	if($newArray['cappasswd'] != $expassword)
	{
		echo"<p><center>密码匹配失败</center></p>";
		header("refresh:1;url=re_key_ad.html");
		exit();
	}
	if($password1 != $password2)
	{
		echo"<p><center>两次输入不一致，请重试</center></p>";
		header("refresh:1;url=re_key_ad.html");
		exit();
	}
	
	
	$sql = "update account set cappasswd = '".$password1."' where account_id = '".$id."'";
	$res = mysqli_query($con,$sql);
	
	if($res)
	{
		echo"<p><center>密码修改成功</center></p>";
		header("refresh:1;url=ad_function.html");
		exit();
	}
	else
	{
		echo"<p><center>修改失败，请重试</center></p>";
		header("refresh:1;url=re_key_ad.html");
		exit();
	}
		mysql_close($con);
?>
</body>
</html>