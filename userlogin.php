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
  $man_id=$_POST['admin_id'];
  $man_password=$_POST['inputPassword'];
  if (!$man_id || !$man_password ) {
       echo "<p><center>输入出错，请重新输入<center><br /></p>";
	   header("refresh:1;url=login.html");
	   exit();
    }

    if (!get_magic_quotes_gpc()){
        $man_id=addslashes($man_id);
        $man_password=addslashes($man_password);
    }
 $con = new mysqli("127.0.0.1","root","Ilovezmf1314!","stock_account");
if (mysqli_connect_error())
{
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}
else
{ 
  $sql="select *from account where account_id ='".$man_id."'";
  $res=mysqli_query($con,$sql);
  if($res == True)
  {
    if ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
      if ($man_password == $newArray['cappasswd']) {
       echo "<p><center>登陆成功<center><br /></p>";
	   header("refresh:1;url=user_func.html");
	   exit();
      }
      else{
      	echo "<p><center>用户名不存在或密码错误，请重新输入<center><br /></p>";
		header("refresh:1;url=userlogin.html");
       exit();
   }
    }
    else{
        echo "<p><center>用户名不存在或密码错误，请重新输入<center><br /></p>";
		header("refresh:1;url=userlogin.html");
       exit();
  }
  mysqli_free_result($res);
  mysqli_close($con);
}
else{
        echo "<p><center>指令执行失败，请重试<center><br /></p>";
       exit();
   }
}
?>
</body>
</html>