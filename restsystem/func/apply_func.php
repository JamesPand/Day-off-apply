 <?php

   //取得假種中文名稱
   function get_usernumber($s){
	require 'connect.php';
	$u_number="";
	
     $result2=mysql_query('select * from user where serial="'.$s.'"');
			while($row2=mysql_fetch_array($result2)){ $u_number=$row2['usernumber'];}
	return $u_number;
	}
 
function get_user_chinese_name($s){
	require 'connect.php';
	$name="";
	
     $result2=mysql_query('select * from user where usernumber="'.$s.'"');
			while($row2=mysql_fetch_array($result2)){ $name=$row2['username'];}
	return $name;
	}
	
	
  //取得假種中文
function get_catname($cat){
	require 'connect.php';
	$cat_name="";
	$result2=mysql_query('select * from cat_dayoff where serial="'.$cat.'"');
			while($row2=mysql_fetch_array($result2)){ $cat_name=$row2['cat'];}
			
	return $cat_name;
	}
function get_user_final_days($n){
	$final_days="";
	$result2=mysql_query('select * from user where usernumber="'.$n.'"');
			while($row2=mysql_fetch_array($result2)){ $final_days=$row2['final_days'];}
	
	return $final_days;
	}

function get_supervisor_email($n){
	
	$email="";
	$result2=mysql_query('select * from user where usernumber="'.$n.'"');
			while($row2=mysql_fetch_array($result2)){ $email=$row2['email'];}
	
	return $email;
	
	}
function get_user_email($n){
	$email="";
	$result2=mysql_query('select * from user where usernumber="'.$n.'"');
			while($row2=mysql_fetch_array($result2)){ $email=$row2['email'];}
	
	return $email;
	
	}
function dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent){
	
				//$mailToname=$a;   //收件者
  				//$mailTo=$b;   //收件者
  				$mailfromname="請假通知";  //寄件者姓名
 				 $mailfrom="daemon.shih@prismabiotech.com.tw";  //寄件者電子郵件
 				// $mailSubject=$c;
 				//$mailContent =$d;
  //以下內容不要改
  				$mailTo="=?UTF-8?B?".base64_encode($mailToname)."?= <" . $mailTo . ">";
 				 $mailfrom="=?UTF-8?B?" . base64_encode($mailfromname) . "?= <" . $mailfrom . ">";
 				 $mailSubject = "=?UTF-8?B?".base64_encode($mailSubject)."?=";  //主旨編碼成UTF-8
 				 mail($mailTo,$mailSubject,$mailContent,"Mime-Version: 1.0\nFrom:" . $mailfrom . "\nContent-Type: text/html ; charset=UTF-8");
					
	}

function group_mail($mailToname,$mailTo,$mailSubject,$mailContent,$mailfromname,$mailfrom){
	
				//$mailToname=$a;   //收件者
  				//$mailTo=$b;   //收件者
  				//$mailfromname="請假通知";  //寄件者姓名
 				 //$mailfrom="daemon.shih@prismabiotech.com.tw";  //寄件者電子郵件
 				// $mailSubject=$c;
 				//$mailContent =$d;
  //以下內容不要改
  				$mailTo="=?UTF-8?B?".base64_encode($mailToname)."?= <" . $mailTo . ">";
 				 $mailfrom="=?UTF-8?B?" . base64_encode($mailfromname) . "?= <" . $mailfrom . ">";
 				 $mailSubject = "=?UTF-8?B?".base64_encode($mailSubject)."?=";  //主旨編碼成UTF-8
 				 mail($mailTo,$mailSubject,$mailContent,"Mime-Version: 1.0\nFrom:" . $mailfrom . "\nContent-Type: text/html ; charset=UTF-8");
					
	}
?>
