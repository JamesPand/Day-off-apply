<?php

			require 'connect.php';
			require 'apply_func.php';
			
			//date_default_timezone_set("Asia/Taipei");
			$dayoffs=$_POST['dayoff'];
			 $serial=$_POST['serial'];
			 
			$un=get_usernumber($serial);
			 $before_dayoff=get_user_final_days($un);
			 
			 $msg=get_user_chinese_name($un).' 更新前特休'.$before_dayoff.'天，更新後'.$dayoffs.'天';
	         $str='INSERT INTO dayoff_record (`serial`, `date`, `usernumber`, `dayoff_log`) VALUES (NULL, \''.date("Y-m-d").'\', \''.$un.'\', \''.$msg.'\')';
			 echo '<script>console.log( "Debug Objects: ' . $str . '" );</script>';
			$result2=mysql_query($str);
			
			 $result=mysql_query('UPDATE user SET final_days ="'.$dayoffs.'" WHERE serial ='.$serial);
?>