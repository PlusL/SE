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
	
	if(!$person_id)
	{
		echo"<p><center>未检测到输入，请重试</center></p>";
		header("refresh:1;url=op_check.html");
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
		$sql="select * from abandon_people where identity = '".$person_id."'";
		$res=mysqli_query($con,$sql);
		$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$sql2="select * from security_user where identity = '".$person_id."'";
		$res2=mysqli_query($con,$sql2);
		$newArray2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);
		$sql3="select acoid from connect where id = '".$person_id."'";
		$res3=mysqli_query($con,$sql3);
		$newArray3 = mysqli_fetch_array($res3, MYSQLI_ASSOC);
		if($res == True)
		{
			if(!$newArray)
			{
				if($res2 == True)
				{
					if(!$newArray2)
					{
						echo"<p><center>信息检测通过</center></p>";
						echo"<p>";
						echo"<a href='indivaccount.html'>办理个人证券账户</a>";
						echo"</p>";
						echo"<p>";
						echo"<a href='corporation.html'>办理法人证券账户</a>";
						echo"</p>";
						exit();
					}
					else
					{
						echo"<p><center>检测到已办理证券账户</center></p>";
						if(!$newArray3)
						{
							echo"<p>";
							echo"<a href='coporation.html'>办理资金账户</a>";
							echo"</p>";
							exit();
						}
						else
						{
							echo"<p><center>检测到已办理资金账户</center></p>";
							echo"<p>";
							echo"<a href='ad_function.html'>返回功能选单</a>";
							echo"</p>";
							exit();
						}
						
					}
				}
			}
			else
			{
				echo"<p><center>您已被限制入市</center></p>";
				echo"<p>";
				echo"<a href='ad_function.html'>返回功能选单</a>";
				echo"</p>";
				exit();	
			}
		}
	Mysqli_close($con);	
		
	}
?>
</body>
</html>