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
<h1>審核記錄</h1>
<form id="form1" name="form1" method="post" action="">
  <label for="selectyear"></label>
  <select name="selectyear" id="selectyear">
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
    <option value="2020">2020</option>
  </select>
  年
  <label for="selectmonth"></label>
  <select name="selectmonth" id="selectmonth">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
  </select> 
  月 
  <input type="submit" name="submit" id="submit" value="送出" />
</form>
<p id="msg" name="msg"></p>
<table width="700" border="1" align="center" id="listtable">
   <tr>
  	<td width="30"><div align="center">No.</div></td>
    <td width="70"><div align="center">申請日</div></td>
    <td width="260"><div align="center">休假日</div></td>
    <td width="30"><div align="center">假種</div></td>
    <td width="30"><div align="center">天數</div></td>
    <td width="50"><div align="center">申請人</div></td>
    <td width="150"><div align="center">備註</div></td>
    <td width="70"><div align="center">審核結果</div></td>
  </tr>
  <?php

    session_start();
	require 'connect.php';
	require 'func/apply_func.php';
	
	$result=mysql_query('select * from power where usernumber="'.$_SESSION['usernumber'].'" ');
	
	echo '<script>$("#msg").text("'.$_SESSION['usernumber'].'");</script>';
	if(mysql_num_rows($result)==1){
		
	   while($row = mysql_fetch_array($result)){
        $_SESSION['userpower']=$row['user_level'];
		
   	   }
	    
		if($_SESSION['userpower']=="1"){
			echo '<script>$("#msg").text("");$("#msg").text("權限不足");</script>';
			echo '<script>$("#listtable").remove();</script>';
			}else{
				echo '<script>$("#msg").text("");$("#msg").text("如下資訊。");</script>';	
				//列出此位使用者可以審核的內容
				if(isset($_POST['selectyear'])){
					$str=$_POST['selectyear'].'-';
					if($_POST['selectmonth'] != '0'){
						if($_POST['selectmonth'] < '10')
						$str.='0'.$_POST['selectmonth'];
						else $str.=$_POST['selectmonth'];
						
					}
					$sqlstr='select * from dayoff where startdate LIKE \''.$str.'%\' order by number desc';
				//	echo '<script>$("#msg").text("'.$sqlstr.'");</script>';
					$result3=mysql_query($sqlstr);
						while($row = mysql_fetch_array($result3)){
						//$n=1;
						$number=$row['number'];     //等同其它table的serial(取名不一致...)
						$applydate=$row['applydate'];
   	   					$startdate=$row['startdate'];
						$enddate=$row['enddate'];
						$status=$row['status'];
						$applyer=$row['applyer'];
						$cat=$row['cat'];
						$cat_name="";
						$applyer_name="";
						$dayoff=$row['dayoff'];
						$comment=$row['comment'];
						$max_check_level=$row['max_check_level'];
						$now_check_level=$row['now_check_level'];
						
						//取得假種中文
						$cat_name=get_catname($cat);
						//取得申請人中文
						$applyer_name=get_user_chinese_name($applyer);						
						
						
					echo '<tr id="t'.$number.'">';
					echo '<td><div align="center">'.$number.'</div></td>';
					echo '<td><div align="center">'.$applydate.'</div></td>';
					echo '<td><div align="center">'.$startdate.' ~ '.$enddate.'</div></td>';
					echo '<td><div align="center">'.$cat_name.'</div></td>';
					echo '<td><div align="center">'.$dayoff.'</div></td>';
					
					echo '<td><div align="center">'.$applyer_name.'</div></td>';	
					echo '<td><div align="center">'.$comment.'</div></td>';	
					echo '<td><div align="center">'.$status.'</div></td>';
					echo '</tr>';}
					}else{
				//$result2=mysql_query('select * from dayoff where now_check_level >= \''.$_SESSION['userpower'].'\' order by number desc');
				$result2=mysql_query('select * from dayoff order by number desc');
				while($row = mysql_fetch_array($result2)){
						//$n=1;
						$number=$row['number'];     //等同其它table的serial(取名不一致...)
						$applydate=$row['applydate'];
   	   					$startdate=$row['startdate'];
						$enddate=$row['enddate'];
						$status=$row['status'];
						$applyer=$row['applyer'];
						$cat=$row['cat'];
						$cat_name="";
						$applyer_name="";
						$dayoff=$row['dayoff'];
						$comment=$row['comment'];
						$max_check_level=$row['max_check_level'];
						$now_check_level=$row['now_check_level'];
						
						//取得假種中文
						$cat_name=get_catname($cat);
						//取得申請人中文
						$applyer_name=get_user_chinese_name($applyer);						
						
						
					echo '<tr id="t'.$number.'">';
					echo '<td><div align="center">'.$number.'</div></td>';
					echo '<td><div align="center">'.$applydate.'</div></td>';
					echo '<td><div align="center">'.$startdate.' ~ '.$enddate.'</div></td>';
					echo '<td><div align="center">'.$cat_name.'</div></td>';
					echo '<td><div align="center">'.$dayoff.'</div></td>';
					
					echo '<td><div align="center">'.$applyer_name.'</div></td>';
					echo '<td><div align="center">'.$comment.'</div></td>';	
					echo '<td><div align="center">'.$status.'</div></td>';
					echo '</tr>';
					//$n++;
				}
				}
			}
				
	}	
?>
  
  
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>


</div>
<!-- end #container --></div>
</body>
</html>
