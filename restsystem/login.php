<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>登入</title>
<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* 比較好的做法是將 Body 元素的邊界與欄位間隔調整為零，以處理不同的瀏覽器預設值 */
	padding: 0;
	text-align: center; /* 這樣會讓容器在 IE 5* 瀏覽器內置中對齊。然後，文字會在 #container 選取器中設定為靠左對齊預設值 */
	color: #000000;
}
.oneColFixCtrHdr #container {
	width: 780px;  /* 使用比完整 800px 少 20px 的寬度會允許使用瀏覽器邊框並且避免水平捲軸出現 */
	background: #FFFFFF;
	margin: 0 auto; /* 自動邊界 (搭配寬度) 會讓頁面置中對齊 */
	border: 1px solid #000000;
	text-align: left; /* 這樣做會覆寫 Body 元素上的 text-align: center。 */
}
.oneColFixCtrHdr #header {
	padding: 0 10px 0 20px;  /* 這個欄位間隔符合下面顯示的 Div 中，元素的靠左對齊。如果在 #header 中使用影像而非文字，您可能會想要移除欄位間隔。 */
	background-color: #66CCFF;
}
.oneColFixCtrHdr #header h1 {
	margin: 0; /* 將 #header Div 中最後一個元素的邊界調整為零可避免邊界收合 (Div 之間出現的空間，無法解釋)。如果 Div 的周圍具有邊框，這就不是必要動作，因為該項設定也會避免邊界收合 */
	padding: 10px 0; /* 使用欄位間隔而非邊界便可讓元素遠離 Div 的邊緣 */
}
.oneColFixCtrHdr #mainContent {
	padding: 0 20px; /* 請記住，欄位間隔就是 Div 方塊內部的空間，而邊界就是 Div 方塊外部的空間 */
	background: #FFFFFF;
}
.oneColFixCtrHdr #footer {
	padding: 0 10px; /* 這個欄位間隔符合上面顯示的 Div 中，元素的靠左對齊。 */
	background:#DDDDDD;
}
.oneColFixCtrHdr #footer p {
	margin: 0; /* 將頁尾中第一個元素的邊界調整為零可避免邊界收合的可能性 (Div 之間出現的空間) */
	padding: 10px 0; /* 這個元素的欄位間隔將會建立空間，就如同邊界一樣，但是沒有邊界收合的問題 */
}
.style1 {
	color: #000000
}
-->
</style>
</head>

<body class="oneColFixCtrHdr">
<?php
/**啟動sesstion，之後判斷 表單是否有送出帳號密碼，
    

**/
session_start();
if(isset($_POST['bttLogin'])){
	require 'connect.php';
	$username=$_POST['username'];
	$password=$_POST['password'];
	$result=mysql_query('select * from user where usernumber="'.$username.'" and password="'.$password.'"');
	if(mysql_num_rows($result)==1){
		
	   while($row = mysql_fetch_array($result)){
        $_SESSION['usernumber']=$row['usernumber'];
		$_SESSION['email']=$row['email'];
		$_SESSION['final_days']=$row['final_days'];
		$_SESSION['username']=$row['username'];
		$_SESSION['system']='dayoff';
   	   }
	    
		header('Location: apply.php');
	}else{
	   echo "帳號或密碼錯誤";
	   header('Location: login.php');
	}	
}else if(isset($_SESSION['username'])){
header('Location: apply.php');
	
}

?>
<form method="post">
<div id="container">
  <div id="header">
    <h1 class="style1">請假系統</h1>
  <!-- end #header --></div>
  <div id="mainContent">
<p align="center">&nbsp;</p>
<p align="center">帳號:
  <label>
    <input type="text" name="username" id="username" />
  </label>
</p>
<p align="center">密碼:
  <label>
  <input type="password" name="password" id="password" />
  </label>
</p>
<p align="center">
  <label>
  <input type="submit" name="bttLogin" id="bttLogin" value="登入"  />
  </label>
  <script>
function openSon()
{
  wson=window.open('icons/2017-hr.jpg',
    '', 'alwaysRaised=yes, width=750, height=500, scrollbars=yes');
}
  </script>
</p>
<h5> >&emsp;&emsp;&emsp;<a href="javascript:openSon()" >人事行政局2017年行事曆</a></h5>
<!--
最新匯率
<table width="308" border="1">
  <tr>
    <td width="62">&nbsp;</td>
    <td width="119">即期買入</td>
    <td width="105">即期賣出</td>
  </tr> 
</table>
-->
<?php
require 'connect.php';
require 'func/apply_func.php';
   //列出最新請假人員
   $str="select * from dayoff order by number desc limit 5";
   $results=mysql_query($str);
   while($row=mysql_fetch_array($results)){
   	$halfday="";
   		//以下小判斷，如果為0.5天就顯示半天，因為0.5天很奇怪
	   	if($row['dayoff'] === "0.5"){
	   		$halfday="半";
	   	}else{
	   		$halfday=$row['dayoff'];
	   	}
   	echo $row['startdate']."日 ".get_user_chinese_name($row['applyer'])."     請假".$halfday."天"."<br>";
   }
?>

<h3>最新公告</h3>
<p>  
      <!-- end #mainContent --></p>
  </div>
  <div id="footer">
<p>Design by Daemon</p>

  <!-- end #footer --></div>
<!-- end #container --></div>
</form>

</body>
</html>
