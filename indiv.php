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
	$person_id = $_POST['$personid'];
	$name = $_POST['$name'];
	$sex = $_POST['$sex'];
	$tele = $_POST['$tele'];
	$academic = $_POST['$academic'];
	$address = $_POST['$address'];
	$company = $_POST['$company'];
	$career = $_POST['$career'];
	$delname = $_POST['$delname'];
	$delid = $_POST['$delid'];
	$isdel = $_POST['$isdel'];
	
	if(!$person_id || !$name || !$sex || !$tele ||!$academic ||!$address || !$company || !$career)
	{
		echo"<p><center>输入存在遗漏，请重新录入</center></p>";
		header("refresh:1;url=indivaccount.html");
		exit();
	}
	if($isdel)
	{
		if(!$delid || !$delname)
		{
			echo"<p><center>代办人信息有漏，请重新录入</center></p>";
			header("refresh:1;url=indivaccount.html");
			exit();
		}
	}
	
	$con = new mysqli("127.0.0.1","root","Ilovezmf1314!","stock_account");
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	else
	{
		$sql="select top 1 * from security_user order by id desc";
		$res=mysqli_query($con,$sql);
		if($res == True)
		{
			$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$aid = intval($newArray['id']);
			$aid = $aid + 1;
			$a_id = strval($aid);
		}
		
		$sql1="insert into individual_security_user values ('".$a_id."','".$person_id."','".$address."','".$company."','".$name."','".$sex."','".$tele."','".$career."','".$delname."','".$delid."')";
		$res1=mysqli_query($con,$sql1);
		
		$sql2="insert into security_user values('".$a_id."','".$person_id."','".$name."','1','0')";
		$res2=mysqli_query($con,$sql2);
		
		$sql3="insert into connect values('".$person_id."',NULL,NULL)";
		$res3=mysqli_query($con,$sql3);
		
		$sql4="update connect set secid = '".$a_id."' where id = '".$person_id."'";
		$res4=mysqli_query($con,$sql4);

		if($res1 == True &&$res2 == True && $res3 == True && $res4 == True)
    	{
    		 echo "<p><center>办理成功<center></p>";
			 echo "<p>您的证券账户账号为：</p>";
			 echo $a_id;
			 echo "</br>";
			 echo "<P>";
			 echo "<a href='capaccount.html'><button class='btn-large'>办理资金账户</button></a>";
			 echo "</p>";
			 echo "<a href='ad_function.html'><button class='btn-large'>返回</button></a>";
    	}
    	else
    	{
    		echo "<p><center>添加失败，请重试<center></p>";
        	header("refresh:1;url=indivaccount.html");
			exit();
    	}
    	Mysqli_close($con);
		
	}

	
?>
</body>
</html>