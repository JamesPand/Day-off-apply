<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<form name="f1" action="test.php" method="post">
<input type="submit" value="submit" />
</form>

<?php
			//require 'connect.php';
			require 'apply_func.php';
			$dayoffs=2;
			
 			$un=get_usernumber("24");
			 $before_dayoff=get_user_final_days($un);
			 $msg=get_user_chinese_name($un).' 更新前特休'.$before_dayoff.'天，更新後'.$dayoffs.'天';
	         $str='INSERT INTO dayoff_record (`serial`, `date`, `usernumber`, `dayoff_log`) VALUES (NULL, \''.date("Y-m-d").'\', \''.$un.'\', \''.$msg.'\')';
			 echo '<script>console.log( "Debug Objects: ' . $str . '" );</script>';
			$result2=mysql_query($str);


?>
</body>
</html>