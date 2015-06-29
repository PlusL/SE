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
	$type = $_POST['type'];
	$person_id = $_POST['personid'];
	$method = $_POST['method'];
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
	
	
	switch ($type) 
		 {
    	case '1':
    		re_sec();
    		break;
    	case '2':
    		re_aco();
    		break;
    	default:
    		break;
    	}

function re_sec()
{
	global $con, $person_id, $method;

		$sql="select * from security_user where identity = '".$person_id."'";
		$res = mysqli_query($con,$sql);
		$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);	
		

		if(!$newArray)
		{
			echo"<p><center>不存在证券账户</center></p>";
			header("refresh:2;url=re_check.html");
			exit();
		}
		else
		{
			if($newArray['flag'])
			{
				echo"<p><center>证券账户仍活跃</center></p>";
				header("refresh:2;url=ad_function.html");
				exit();
			}
			else
			{
				if($method == '2')
				{
					$sql1 = "update security_user set flag = 1 where identity = '".$person_id."'";
					$res1 = mysqli_query($con,$sql1);
					
					if($res1)
					{
						echo"<p><center>补办成功</center></p>";
						echo"<p><center>账户账号为：  ";
						echo $newArray['id'];
						echo "</center></p>";
						header("refresh:3;url=ad_function.html");
						exit();
					}
					else
					{
						echo"<p><center>出现错误，请重试</center></p>";
						header("refresh:2;url=re_check.html");
						exit();
					}
				}
				if($method == '1')
				{
					if($newArray['type']==0)
					{
						header("url=re_indiv.html");
						exit();
					}
					if($newArray['type']==1)
					{
						header("url=re_corpo.html");
						exit();
					}
					
					
				}
				
			}
		}
}

function re_aco()
{
	global $con, $person_id, $method;

		$sql="select * from account where identity = '".$person_id."'";
		$res = mysqli_query($con,$sql);
		$newArray = mysqli_fetch_array($res, MYSQLI_ASSOC);	
		

		if(!$newArray)
		{
			echo"<p><center>不存在资金账户</center></p>";
			header("refresh:2;url=re_check.html");
			exit();
		}
		else
		{
			if($newArray['flag'])
			{
				echo"<p><center>资金账户仍活跃</center></p>";
				header("refresh:2;url=ad_function.html");
				exit();
			}
			else
			{
				if($method == '2')
				{
					$sql1 = "update account set flag = 1 where identity = '".$person_id."'";
					$res1 = mysqli_query($con,$sql1);
					
					if($res1)
					{
						echo"<p><center>补办成功</center></p>";
						echo"<p><center>账户账号为：  ";
						echo $newArray['account_id'];
						echo "</center></p>";
						header("refresh:3;url=ad_function.html");
						exit();
					}
					else
					{
						echo"<p><center>出现错误，请重试</center></p>";
						header("refresh:2;url=re_check.html");
						exit();
					}
				}
				if($method == '1')
				{
					header("re_aco.html");
					exit();
					
					
				}
			}
		}
				
}
mysqli_close($con);

?>
</body>
</html>