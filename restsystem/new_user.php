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
<link type="text/css" href="js/jquery-ui.structure.min.css" rel="stylesheet" />   
 <link type="text/css" href="js/jquery-ui.min.css" rel="stylesheet" /> 
  <link rel="stylesheet" href="js/images/style.css">
  <link rel="stylesheet" href="js/jquery-ui-timepicker-addon.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datepicker-zh-TW.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<div id="container">
  <?php
  require 'abilities.php';
  require 'checklogin.php';
 ?>
  <div id="mainContent">
<h1>使用者管理</h1>
<p id="msg" name="msg"></p>
<?php

    session_start();

?>
<form method="post">
<p>姓名:
  <label for="newuser_name"></label>
  <input name="newuser_name" type="text" id="newuser_name" />
  工號:
  <label for="newuser_number"></label>
  <input type="text" name="newuser_number" id="newuser_number" />
</p>
<p>特休假:
  <label for="user_dayoff"></label>
  <input type="text" name="user_dayoff" id="user_dayoff" /> 
  層級:
  <label for="power_level"></label>
  <input type="text" name="power_level" id="power_level" />
</p>
<p>email:
  <label for="user_email"></label>
  <input type="text" name="user_email" id="user_email" /> 
  密碼:
  <label for="password"></label>
  <input name="password" type="text" id="password" />
  <input type="submit" name="add_user" id="add_user" value="新增" />
</p>
</form>
<?php
  require 'connect.php';
   if(isset($_POST['add_user'])){
		$result=mysql_query('INSERT INTO user (`serial`, `username`, `password`, `usernumber`, `email`, `final_days`) VALUES (NULL, \''.$_POST['newuser_name'].'\', \''.$_POST['password'].'\', \''.$_POST['newuser_number'].'\', \''.$_POST['user_email'].'\', \''.$_POST['user_dayoff'].'\')');
		$result2=mysql_query('INSERT INTO power (`serial`, `cat`, `user_level`, `usernumber`) VALUES (NULL, \'1\', \''.$_POST['power_level'].'\', \''.$_POST['newuser_number'].'\')');
   }

?>
<p>&nbsp;</p>
<script>
function updateuser(ser,day){
	
	
    $.ajax({
        url: "func/update_user.php",
        data: {
            dayoff: day,serial:ser
        },
        type: "POST",
        dataType: "html",
        success: function(data) {
          $('#msg').text("變更特休天數:"+day+" 工號:"+ser+"成功");
        },
        error: function() {
             $('#msg').text("更新失敗");
        }
        
    });

	
	}
</script>
<table width="700" border="1" align="center" id="listtable">
  <tr>
    <td width="34"><div align="center">序號</div></td>
    <td width="74"><div align="center">姓名</div></td>
    <td width="37"><div align="center">工號</div></td>
    <td width="369"><div align="center">Email</div></td>
    <td width="51"><div align="center">特休</div></td>
    <td width="95"><div align="center">確定</div></td>
  </tr>
<?php
     require 'connect.php';
		 
		 $listuser=mysql_query('select * from user');
		 $n=1;
		  while($row = mysql_fetch_array($listuser)){
			  echo '<tr>';
			  echo '<td><div align="center" id="serial'.$n.'">'.$row['serial'].'</div></td>';
			  echo '<td><div align="center">'.$row['username'].'</div></td>';
			  echo '<td><div align="center">'.$row['usernumber'].'</div></td>';
			  echo '<td><div align="center">'.$row['email'].'</div></td>';
			  echo '<td><input type="text" name="dayoffs" id="dayoff'.$n.'" style="width:60px;" value="'.$row['final_days'].'" /></td>';
			  echo '<td><label><div align="center"></div> <input type="submit" name="updatebtn" id="updatebtn" value="修改" onclick="updateuser(serial'.$n.'.innerHTML,dayoff'.$n.'.value)" /></label></td>';
			  echo '</tr>';
		       $n++;  
		
		 
		 }
		 /*
		 if(isset($_POST['updatebtn'])){
			 $dayoffs=$_POST['dayoff'];
			 $serial=$_POST['serial'];
			 $result=mysql_query('UPDATE user SET final_days ="'.$dayoffs.'" WHERE serial ='.$serial);
			// $result=mysql_query('UPDATE user SET final_days ="2" where serial = 1');
			 }*/
		 
  ?>
 
  
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<?php

    session_start();
	require 'connect.php';
	require 'func/apply_func.php';
	
	$result=mysql_query('select * from power where usernumber="'.$_SESSION['usernumber'].'"');
	
	echo '<script>$("#msg").text("您現在的登入的身份為:'.get_user_chinese_name($_SESSION['usernumber']).'。");</script>';
	if(mysql_num_rows($result)==1){
		
	   while($row = mysql_fetch_array($result)){
        $_SESSION['userpower']=$row['user_level'];
		
   	   }
	    
		if($_SESSION['userpower']=="1"){
			echo '<script>$("#msg").text("");$("#msg").text("權限不足");</script>';
			echo '<script>$("#newuser_number").attr("disabled", true);</script>';
			echo '<script>$("#newuser_name").attr("disabled", true);</script>';	
			echo '<script>$("#user_dayoff").attr("disabled", true);</script>';
			echo '<script>$("#power_level").attr("disabled", true);</script>';
			echo '<script>$("#user_email").attr("disabled", true);</script>';
			echo '<script>$("#password").attr("disabled", true);</script>';	
			echo '<script>$("#add_user").remove();</script>';	
			echo '<script>$("#listtable").remove();</script>';	
			}
			else{
				
				}
	}	
?>
</div>
<!-- end #container --></div>
</body>
</html>
