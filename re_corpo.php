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
	$name = $_POST['name'];
	$person_id = $_POST['personid'];
	$companyid = $_POST['companyid'];
	$businessid = $_POST['businessid'];
	$tele = $_POST['tele'];
	$address = $_POST['$address'];
	$auid = $_POST['auid'];
	$autele = $_POST['autele'];
	$auaddress = $_POST['auaddress'];

	
	if(!$name||!$person_id || !$companyid || !$businessid || !$tele ||!$address||!$auaddress||!$auid||!$autele)
	{
		echo"<p><center>输入存在遗漏，请重新录入</center></p>";
		header("refresh:1;url=re_corpo.html");
		exit();
	}

	$con = new mysqli($url,$user,$pwd,$db);
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	else
	{
		$sql="select * from security_user order by id desc limit 0,1";
		$res=mysqli_query($con,$sql);
		if($res == True)
		{
			$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$aid = intval($newArray['id']);
			$aid = $aid + 1;
			$a_id = strval($aid);
		}
		
		
		$sql2="insert into security_user values('".$a_id."','".$person_id."','".$companyid."','1','1')";
		$res2=mysqli_query($con,$sql2);
		
		$sql1="insert into company_security_user values ('".$a_id."','".$person_id."','".$companyid."','".$businessid."','".$address."','".$tele."','".$name."','".$auid."','".$autele."','".$auaddress."')";
		$res1=mysqli_query($con,$sql1);
		
		$sql3 = "update connect set id = '".$a_id."' where identity = '".$person_id."'";
		$res3 = mysqli_query($con,$sql3);
		
		$sql4 = "select id from security_user where identity = '".$person_id."' and id <> '".$a_id."'";
		$res4 = mysqli_query($con,$sql4);
		$exid = mysqli_fetch_array($res4,MYSQLI_ASSOC);
		
		$sql5 = "update account_stock set id = '".$a_id."' where id = '".$exid."'";
		$res5 = mysqli_query($con,$sql5);
		
		$sql6 = "delete from security_user where id = '".$exid."'";
		$res6 = mysqli_query($con,$sql6);
		
		$sql7 = "delete from company_security_user where id = '".$exid."'";
		$res7 = mysqli_query($con,$sql7);

		if($res1&&$res2&&$res3&&$res4&&$res5&&$res6&&$res7)
		
    	{
    		 echo "<p><center>办理成功<center></p>";
			 echo "<p>您的证券账户账号为：</p>";
			 echo $a_id;
			 echo "</br>";
			 header("refresh:3;url=ad_function.html");
			 exit();
    	}
    	else
    	{
    		echo "<p><center>添加失败，请重试<center></p>";
        	header("refresh:1;url=re_corpo.html");
			exit();
    	}
    	Mysqli_close($con);
		
	}

	
?>
</body>
</html>