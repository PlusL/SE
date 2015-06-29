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
	$person_id = $_POST['personid'];
	$type = $_POST['type'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$passwords = $_POST['passwords'];
	$repasswords = $_POST['repasswords'];
	
	if(!$person_id || !$type || !$password ||!$repassword ||!$passwords || !$repasswords)
	{
		echo"<p><center>输入有遗漏，请重试</center></p>";
		header("refresh:2;url=re_aco.html");
		exit();
		
	}
	if($password != $repassword)
	{
		echo"<p><center>取款密码两次输入不一致,请重新输入</center></p>";
		header("refresh:2;url=re_aco.html");
		exit();
	}
	if($passwords != $repasswords)
	{
		echo"<p><center>交易密码两次输入不一致，请重新输入</center></p>";
		header("refresh:2;url = re_aco.html");
		exit();
	}
	if(!get_magic_quotes_gpc())
	{
		$person_id = addslashes($person_id);
		$password = addslashes($password);
		$repassword = addslashes($repassword);
		$password = addslashes($password);
		$repassword = addslashes($repassword);
	}
	$con = new mysqli($url,$user,$pwd,$db);
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	else
	{
		$sql1="select top 1 * from account order by account_id desc";
		$res1=mysqli_query($con,$sql1);
		if($res == True)
		{
			$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$accountid = intval($newArray['account_id']);
			$accountid = $accountid + 1;
			$account_id = strval($accountid);
		}
		
		$sql="update account set account_id = '".$account_id."' where identity='".$person_id."'";
    	$res=mysqli_query($con,$sql);
		$sql2="update account set cappasswd = '".$password."' where identity='".$person_id."'";
    	$res2=mysqli_query($con,$sql2);
		$sql3="update account set signpasswd = '".$passwords."' where identity='".$person_id."'";
    	$res3=mysqli_query($con,$sql3);
		
		$sql4="update connect set acoid = '".$account_id."' where id='".$person_id."'";
		$res4=mysqli_query($con,$sql2);
    	if($res == True &&$res2 == True&&$res3==True&&$res4==True)
    	{
    		 echo "<p><center>办理成功<center></p>";
			 echo "<p>您的资金账户账号为：</p>";
			 echo $account_id;
			 echo "</br>";
			 echo "<a href='ad_function.html'><button class='btn-large'>返回</button></a>";
    	}
    	else
    	{
    		echo "<p><center>添加失败，请重试<center></p>";
        	header("refresh:1;url=capaccount.html");
			exit();
    	}
    	Mysqli_close($con);
	}
?>
</body>
</html>