<?php

	require 'connect.php';
	require 'apply_func.php';
	$aggreement=$_POST['aggreement']; //審核為通過或不通過O , X
	$serial=$_POST['number'];			//核假的系統編號
	$userpower=$_POST['power'];			//核假人的權力等級
	$userpower++;						//核完後審核階層加一
	$cat=$_POST['cat'];					//如果此假為特休，則要更新使用者的final days
	$applyer=$_POST['applyer'];
	$dayoff=$_POST['dayoff'];
	$supervisor_number=$_POST['supervisor'];
	if($cat == "1" && $aggreement=="O"){
		
			$user_final=get_user_final_days($applyer);
			$u=$user_final - $dayoff;
		$result2=mysql_query('UPDATE user SET final_days = \''.$u.'\' WHERE usernumber ='.$applyer.';');
		
		}
	$result=mysql_query('UPDATE dayoff SET now_check_level = \''.$userpower.'\',status = \''.$aggreement.'\', supervisor= \''.$supervisor_number.'\' WHERE number ='.$serial.';');

	if($aggreement=="O"){
		
		$result3=mysql_query('select * from dayoff where number='.$serial);
		while($row = mysql_fetch_array($result3)){
			$startdate=$row['startdate'];
			$enddate=$row['enddate'];
			$dayoff=$row['dayoff'];
			$cat=$row['cat'];
			
			//底下為通過後寄給人事小姐
			$mailToname="Nina";
			$mailTo=get_user_email($applyer);  //
			$mailSubject=get_user_chinese_name($applyer)."請假 ".get_catname($cat).$dayoff."天 已通過";
			$mailContent =get_user_chinese_name($applyer)." 於".$startdate." ~ ".$enddate."請假".$dayoff."天。\r<br> 詳情請到 http://192.168.1.9/restsystem  查看" ;
			dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent);
		}
		
		}

		if($aggreement=="X"){
						
			//底下為未通過後寄給申請人
			$mailToname=get_user_chinese_name($applyer);
			$mailTo=get_user_email($applyer);  //
			$mailSubject=get_user_chinese_name($applyer)."請假 ".get_catname($cat).$dayoff."天 未通過";
			$mailContent =" 您的請假申請未通過。" ;
			dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent);
			
			
			}


	//UPDATE `daemon`.`dayoff` SET `now_check_level` = '3',`status` = 'O' WHERE `dayoff`.`number` =2;
	
	//底下可加條件，判斷是否要送交人事室
	    /**
		if ($aggreement=="O"){
		mb_internal_encoding("utf-8");
				//$to=get_supervisor_email($_POST['supervisor']);
				$to="nina@prismabiotech.com.tw";
				$subject=mb_encode_mimeheader(get_user_chinese_name($_SESSION['usernumber'])." ".get_catname($_POST['cat']).$_POST['days']."天 申請","utf-8");
				$message="請到 http://192.168.1.9/restsystem/ 查看申請";
				$headers="MIME-Version: 1.0\r\n";
				$headers.="Content-type: text/html; charset=utf-8\r\n";
				$headers.="From:".mb_encode_mimeheader("請假系統","utf-8")."<monasd1si@gmail.com>\r\n";
				//mail($to,$subject,$message,$headers);
		        mail($to,$subject,$message,$headers);
		}
		**/

?>
