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
	$password1 = $_POST['password'];
	$password2 = $_POST['repassword'];
	
	if(!$password1 || !$password2)
	{
		echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=re_key.html");
		exit();
	}
	
	if($password1 != $password2)
	{
		echo"<p><center>两次输入不一致，请重试</center></p>";
		header("refresh:1;url=re_key.html");
		exit();
	}
	
	$con = new mysqli("127.0.0.1","root","Ilovezmf1314!","stock_account");
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$sql = "update account set cappasswd = '".$password1."' where account_id = '".$_SESSION['user']."'";
	$res = mysqli_query($con,$sql);
	
	if($res)
	{
		echo"<p><center>密码修改成功，请牢记您的新密码</center></p>";
		header("refresh:1;url=user_func.html");
		exit();
	}
	else
	{
		echo"<p><center>修改失败，请重试</center></p>";
		header("refresh:1;url=re_key.html");
		exit();
	}
		mysql_close($con);
?>
</body>
</html>