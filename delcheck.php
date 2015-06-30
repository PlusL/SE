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
	$account_id = $_POST['accountid'];
	$person_id = $_POST['personid'];
	$type = $_POST['type'];
	if(!$account_id||!$person_id)
	{
		
	    echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=del_check.html");
		exit();
    }
	
	$con = new mysqli($url,$user,$pwd,$db);
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	switch ($type) 
		 {
    	case 'a':
    		del_sec();
    		break;
    	case 'b':
    		del_aco();
    		break;

    	default:
    		break;
    	}
	
	function del_sec()
	{
		global $con, $account_id, $person_id;
		
		$sql1 = "select * from security_user where identity = '".$person_id."'";
		$res1 = mysqli_query($con,$sql1);
		$newArray1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
		
		if($account_id != $newArray1['id'])
		{
			echo"<p><center>信息不匹配，请重新验证</center></p>";
			header("refresh:2;url = del_check.html");
			exit();
		}
		$sql2 = "select account_id from connect where identity = '".$person_id."' and id = '".$account_id."'";
		$res2 = mysqli_query($con,$sql2);
		$newArray2 = mysqli_fetch_array($res2,MYSQLI_ASSOC);
		
		if($newArray2)
		{
			$sql3 = "select * from account where account_id = '".$newArray2."'";
			$res3 = mysqli_query($con,$sql3);
			$newArray3 = mysqli_fetch_array($res3,MYSQLI_ASSOC);
			
			if($newArray3['presentcap'] != 0)
			{
				echo"<p><center>关联资金账户仍有余额，请先转出</center></p>";
				header("refresh:3;url = ad_function.html");
				exit();
			}
			$sql4 = "delete from account where account_id = '".$newArray2."'";
			$res4 = mysqli_query($con,$sql4);
		}
		$sql6 = "select * from account_stock where id = '".$account_id."'";
		$res6 = mysqli_query($con,$sql6);
		$newArray4 = mysqli_fetch_array($res6,MYSQLI_ASSOC);
		
		if($newArray4)
		{
			echo"<p><center>名下仍有未售出股票，请先售出或转让</center></p>";
			header("refresh:3;url = ad_function.html");
			exit();
		}
			
			if($newArray1['type'])
			{
				$sql5 = "delete from company_security_user where id = '".$account_id."'";
				$res5 = mysqli_query($con,$sql5);
			}
			else
			{
				$sql5 = "delete from individual_security_user where id = '".$account_id."'";
				$res5 = mysqli_query($con,$sql6);
			}
			
			$sql7 = "delete from security_user where id = '".$account_id."'";
			$res7 = mysqli_query($con,$sql7);
			
			$sql8 = "delete from connect where identity = '".$person_id."'";
			$res8 = mysqli_query($con,$sql8);
			
			if($res4&&$res5&&$res7&&$res8)
			{
				echo"<p><center>销户成功，即将返回功能界面</center></p>";
				header("refresh:3;url = ad_function.html");
				exit();	
			}
			else
			{
				echo"<p><center>销户失败，请重新操作</center></p>";
				header("refresh:3;url = del_check.html");
				exit();	
			}
					
	}
	
	function del_aco()
	{
		global $con, $account_id, $person_id;
		
		$sql1 = "select * from account where identity = '".$person_id."'";
		$res1 = mysqli_query($con,$sql1);
		$newArray1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
		
		if($account_id != $newArray1['account_id'])
		{
			echo"<p><center>信息不匹配，请重新验证</center></p>";
			header("refresh:2;url = del_check.html");
			exit();
		}
		
			
			if($newArray1['presentcap'] != 0)
			{
				echo"<p><center>关联资金账户仍有余额，请先转出</center></p>";
				header("refresh:3;url = ad_function.html");
				exit();
			}
		$sql2 = "delete from account where account_id = '".$account_id."'";
		$res2 = mysqli_query($con,$sql2);
		
		$sql3 = "update connect set acoid = NULL where id = '".$person_id."'";
		$res3 = mysqli_query($con,$sql3);
		
		if($res2&&$res3)
		{
			echo"<p><center>销户成功，即将返回功能界面</center></p>";
				header("refresh:3;url = ad_function.html");
				exit();	
		}
		else
			{
				echo"<p><center>销户失败，请重新操作</center></p>";
				header("refresh:3;url = del_check.html");
				exit();	
			}
	}
	mysql_close($con);
?>
</body>
</html>