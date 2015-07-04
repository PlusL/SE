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
	if(!$person_id)
	{
		echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=loss_check.html");
		exit();
	}
	
	$con = new mysqli($url,$user,$pwd,$db);
	if (mysqli_connect_error())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	if($type == 'a')
	{
		$sql="select * from security_user where identity = '".$person_id."'";
		$res = mysqli_query($con,$sql);
		$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
		if(!$newArray)
		{
			echo"<p><center>尚未办理任何账户</center></p>";
			header("refresh:2;url=ad_function.html");
			exit();
		}
		else
		{
			if(!$newArray['flag'])
			{
				echo"<p>证券账户已挂失</p>";
			}
			else
			{
				$sqlsl="update security_user set flag = '0' where identity = '".$person_id."'";
				$ressl=mysqli_query($con,$sqlsl);
				if($ressl == True)
				{
					echo"<p>";
					echo"挂失证券账户成功";
					echo"</p>";
				}
			}
		}
	}
	if($type == 'b')
	{
		$sql3 = "select * from account where indentity ='".$person_id."'";
		$res3 =  mysqli_query($con,$sql3);
		$newArray3 = mysqli_fetch_array($res3,MYSQLI_ASSOC);
		
		if(!$newArray3['flag'])
						{
							echo"<p>资金账户已挂失</p>";
						}
						else
						{
							$sqlal="update account set flag = '0' where id = '".$newArray2."'";
								$resal=mysqli_query($con,$sqlsl);
								if($resal == True)
								{
									echo"<p>";
									echo"挂失资金账户成功";
									echo"</p>";
								}
							
						}
						
	}

	echo"<p>";
	echo"<a href='ad_function.html'>返回功能界面</a>";
	echo"</p>";
?>
</body>
</html>