<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>請假申請</title>
<style type="text/css">
<!--
body {
	background: #666666;
	margin: 0; /* 比較好的做法是將 Body 元素的邊界與欄位間隔調整為零，以處理不同的瀏覽器預設值 */
	padding: 0;
	text-align: center; /* 這樣會讓容器在 IE 5* 瀏覽器內置中對齊。然後，文字會在 #container 選取器中設定為靠左對齊預設值 */
	color: #0033CC;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 100%;
}
.oneColElsCtr #container {
	width: 46em;
	background: #FFFFFF;
	margin: 0 auto; /* 自動邊界 (搭配寬度) 會讓頁面置中對齊 */
	border: 1px solid #000000;
	text-align: left; /* 這樣做會覆寫 Body 元素上的 text-align: center。 */
}
.oneColElsCtr #mainContent {
	padding: 0 20px; /* 請記住，欄位間隔就是 Div 方塊內部的空間，而邊界就是 Div 方塊外部的空間 */
}
.oneColElsCtr #container #abilities {
	background-color: #0099CC;
}
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body class="oneColElsCtr">
<?php
require 'checklogin.php';
?>
<link type="text/css" href="js/jquery-ui.structure.min.css" rel="stylesheet" />   
 <link type="text/css" href="js/jquery-ui.min.css" rel="stylesheet" /> 
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="js/jquery-ui-timepicker-addon.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datepicker-zh-TW.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<div id="container">
 <?php
  require 'abilities.php';
 ?>
  <div id="mainContent">
<h1> 請假申請</h1>

<form action="apply.php" method="post">
<table width="700" align="center" id="basic" name="basic">
  <tr>
    <td>申請日:<div class="todayDate" id="todayDate">2017/03/29</div></td>
    <td>姓名: <div class="username" id="username">瑞林花子</div></td>
    <td>剩餘特休:<div class="dayoff_final" id="dayoff_final">30</div></td>
  </tr>
</table>
<?php
    //此大段內容為判斷登入者資訊及有沒有送出請假表單
	
	require 'myjs/myjquery.php';
	require 'connect.php';
	require 'func/apply_func.php';
	 date_default_timezone_set("Asia/Taipei"); //時區設定，不然date()函數會有錯，因為使用格林威治時間，不設定的話台灣時間會少八小時
	echo_jquery('$("#todayDate").text("'.date("Y/m/d").'")');
	echo_jquery('$("#username").text("'.$_SESSION['username'].'")');
	echo_jquery('$("#dayoff_final").text("'.$_SESSION['final_days'].'")');
	
	if(isset($_POST['applybtn'])){
		$str='INSERT INTO `daemon`.`dayoff` (`number`, `applyer`,`applydate`, `startdate`, `enddate`, `jobagent`, `supervisor`, `comment`, `dayoff`, `cat`, `max_check_level`, `now_check_level`) VALUES (NULL, \''.$_SESSION['usernumber'].'\',\''.date("Y/m/d").'\', \''.$_POST['startdate'].'\', \''.$_POST['enddate'].'\', \''.$_POST['agent'].'\', \''.$_POST['supervisor'].'\',\' '.$_POST['comment'].'\', \''.$_POST['days'].'\',\' '.$_POST['cat'].'\', \'3\', \''.$_SESSION['nextlevel'].'\')';
		
		$result=mysql_query($str);		
		
				
				$mailToname="";   //收件者
  				$mailTo="";   //收件者
  				$mailfromname="請假通知";  //寄件者姓名
 				 $mailfrom="";  //寄件者電子郵件
 			 $mailSubject=get_user_chinese_name($_SESSION['usernumber'])." ".get_catname($_POST['cat'])."請假".$_POST['days']."天 申請";    //主旨
 				 $mailContent =get_user_chinese_name($_SESSION['usernumber'])." 於".$_POST['startdate']."~".$_POST['enddate']."請假".$_POST['days']."天\r<br> 請到  查看" ;  //內容
  //以下內容不要改
  				/*$mailTo="=?UTF-8?B?".base64_encode($mailToname)."?= <" . $mailTo . ">";
 				 $mailfrom="=?UTF-8?B?" . base64_encode($mailfromname) . "?= <" . $mailfrom . ">";
 				 $mailSubject = "=?UTF-8?B?".base64_encode($mailSubject)."?=";  //主旨編碼成UTF-8
 				 mail($mailTo,$mailSubject,$mailContent,"Mime-Version: 1.0\nFrom:" . $mailfrom . "\nContent-Type: text/html ; charset=UTF-8");
				*/
				dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent);
				$mailToname="";   //收件者
  				$mailTo="";   //收件者
				dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent);
		}
?>
<p>請假起迄日:自
  <label>
  <input name="startdate" type="text" id="startdate" size="17"  />
  分  </label> 
  ,至
  <label>
  <input name="enddate" type="text" id="enddate" size="17" />
  </label>
  <label></label>
  分，共
  <label>
  <input name="days" type="text" id="days" value="1" size="5" />
  </label> 
  天</p>
<p>假別:
  <label>
  <select name="cat" id="cat">
  <?php
  $result=mysql_query('select * from cat_dayoff');
	    while($row = mysql_fetch_array($result)){
        $serial=$row["serial"];
		$cat=$row["cat"];
		echo_jquery('$("#cat").append("<option value='.$serial.'>'.$cat.'</option>");');
   	   }
	   ?>
    </select>
  </label>
</p>
<p>職務代理人:
  <label>
  <select name="agent" id="agent">
  <?php
  $result=mysql_query('select * from user');
	    while($row = mysql_fetch_array($result)){
        $username=$row["username"];
		$usernumber=$row["usernumber"];
		if($usernumber == $_SESSION['usernumber']){
			echo_jquery('$("#agent").append("<option value='.$usernumber.' selected>'.$username.'</option>");');
			}else{
		echo_jquery('$("#agent").append("<option value='.$usernumber.'>'.$username.'</option>");');
		}
   	   }
  ?>    
  </select>
  </label>
</p>
<p>上級主管(核假):
  <label>
  <select name="supervisor" id="supervisor">
  <?php
  $userlevel="";
  $cat=1;       //請假的類別設定為1，如之後開發其它簽核表，此變數會改變
  $supervisor_number=NULL;
  $supervisor_level=NULL;
  $supervisor_name="";
  $supervisor_mail=NULL;
  $result=mysql_query('select * from power where usernumber="'.$_SESSION["usernumber"].'" and cat="'.$cat.'"'); //調出目前user的事件level
   while($row = mysql_fetch_array($result)){
        $userlevel=$row["user_level"];
		$_SESSION['userlevel']=$row["user_level"];
   	   }
	   
	   $userlevel+=1; //算出下一 個level的人
	   $_SESSION['nextlevel']=$userlevel;
	   
	$result=mysql_query('select * from power where user_level="'.$userlevel.'" and cat="'.$cat.'"'); //調出下一個level的人名及編號
	   while($row = mysql_fetch_array($result)){
        $supervisor_number=$row["usernumber"];
		//$supervisor_name=$row["username"];
		//echo_jquery('$("#supervisor").append("<option>").attr("value","'.$supervisor_number.'").text("'.$supervisor_name.'");');
		$result3=mysql_query('select * from user where usernumber="'.$supervisor_number.'"'); //插入option
	    while($row = mysql_fetch_array($result3)){
        $supervisor_email=$row["email"];
		$supervisor_name=$row["username"];
		echo_jquery('$("#supervisor").append("<option value='.$supervisor_number.'>'.$supervisor_name.'</option>");');
   	   }
   	   }
	   
	   
  ?>   
    </select>
  </label>
</p>
<p>備註:</p>
<p>
  <label>
  <input type="text" name="comment" id="comment" />
  </label>
</p>
<p>
  <label>
  <input type="submit" name="applybtn" id="applybtn" value="送出" />
  </label>
</p>
<script>
  $( function() {
    $( "#startdate" ).datetimepicker({dateFormat: "yy-mm-dd",hourMin: 8,hourMax: 18,minuteMin:0,minuteMax:45,hourGrid: 5,
	minuteGrid: 15});
	$( "#enddate" ).datetimepicker({dateFormat: "yy-mm-dd",hourMin: 8,hourMax: 18,minuteMin:0,minuteMax:45,hourGrid: 5,
	minuteGrid: 15});
	$("#starttime").datetimepicker();
	$("#endtime").datetimepicker();
  } );
</script>
</div>
</form>
<!-- end #container --></div>
</body>
</html>
