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
	$num = $_POST['num'];
	$num1 = floatval($num);
	if(!$num)
	{
		echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=store.html");
		exit();
	}
	$con = new mysqli("127.0.0.1","root","Ilovezmf1314!","stock_account");
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$sql = "select * from account where account_id = '".$_SESSION['user']."'";
	$res = mysqli_query($con,$sql);
	$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
	
	if($res)
	{
		if(!$newArray['flag'])
		{
			echo"<p><center>该账户已被冻结，无法进行转账业务</center></p>";
		header("refresh:3;url=user_func.html");
		exit();
		}
		else
		{
			$rest = $newArray['usablecap'] + $num1;
			$sql1 = "update account set usablecap = usablecap + '".$num1."' where account_id = '".$_SESSION['user']."'";
			$res1 = mysqli_query($con,$sql1);
			
			$sql2 = "update account set presentcap = presentcap + '".$num1."' where account_id = '".$_SESSION['user']."'";
			$res2 = mysqli_query($con,$sql2);
			
			if($res1&&$res2)
			{
				echo"<p><center>转账成功</center></p>";
				echo"<p><center>当前账户余额为：  ";
				echo $rest;
				echo $newArray['coin_type'];
				echo "</center></p>";
				header("refresh:3;url=user_func.html");
				exit();
			}
			else
			{
				echo"<p><center>转账失败，请重试</center></p>";
				header("refresh:3;url=user_func.html");
				exit();
			}
			
		}
	}
	else
	{
		echo"<p><center>转账失败，请重试</center></p>";
		header("refresh:3;url=user_func.html");
		exit();
	}
	mysqli_close($con);
?>
</body>
</html>