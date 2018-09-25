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
.ui-datepicker-week-end a { background:#F66 !important; }
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
<h1>群組發信</h1>

<form action="groupmail.php" method="post"><br />
標題<input type="text" name="mailtitle" id="mailtitle"/><br />
內容<br /><textarea name="mailcontent" id="mailcontent" cols="30" rows="10"></textarea><br />
<input type="submit" name="submit" value="寄出" /><br />
<?php
    //此大段內容為判斷登入者資訊及有沒有送出請假表單
	
	require 'myjs/myjquery.php';
	require 'connect.php';
	require 'func/apply_func.php';
	 
	if(isset($_POST['submit'])){
		
	$allmaillist = mysql_query('select * from user where actived="0"');
		$mailTo="";
			while($row = mysql_fetch_array($allmaillist)){
				if($mailTo === ""){
					$mailTo="";
				}else{
					$mailTo.=",";
				}
					$mailTo.=$row['email'];
			}

		$mailToname="Prisma Member";   //收件者
  				  //收件者
  				$mailfromname=get_user_chinese_name($_SESSION['usernumber']);  //寄件者姓名
 				 $mailfrom=get_user_email($_SESSION['usernumber']);  //寄件者電子郵件
 				 
 			 $mailSubject=$_POST['mailtitle'];    //主旨
 		$mailContent =nl2br($_POST['mailcontent']) ."<br /><br />此信由系統發出，勿直接回信。"; 
 		
 			//dayoff_mail($mailToname,$mailTo,$mailSubject,$mailContent);
 		
 			group_mail($mailToname,$mailTo,$mailSubject,$mailContent,$mailfromname,$mailfrom);
 		
		


		}
?>
</form>
<!-- end #container --></div>
</body>
</html>
