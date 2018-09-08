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
<h1> 請假記錄</h1>
<table width="600" border="1" align="center" id="listtable">
  <tr>
    <td>申請日:<div class="todayDate" id="todayDate">2017/03/29</div></td>
    <td>姓名: <div class="username" id="username">瑞林花子</div></td>
    <td>剩餘特休:<div class="dayoff_final" id="dayoff_final">30</div></td>
  </tr>
</table>
<p>
  <?php
require 'myjs/myjquery.php';
echo_jquery('$("#todayDate").text("'.date("Y/m/d").'")');
	echo_jquery('$("#username").text("'.$_SESSION['username'].'")');
	echo_jquery('$("#dayoff_final").text("'.$_SESSION['final_days'].'")');
	
?>
</p>

<form id="form1" name="form1" method="post" action="printcheck.php">
  
  <table width="700" border="0" align="center">
  <tr>
    <td align="right"><input  type="submit" name="checkbtn" id="checkbtn" value="印多張"  /></td>
  </tr>
</table>

  
  <table width="700" border="1" align="center" id="listtable">
    <tr>
    <td width="80" height="46"><div align="center">申請日</div></td>
    <td width="260"><div align="center">休假日</div></td>
    <td width="30"><div align="center">天數</div></td>
    <td width="30"><div align="center">假種</div></td>
    <td width="50"><div align="center">審核人</div></td> 
    <td width="120"><div align="center">備註</div></td>
    <td width="30"><div align="center">狀態</div></td>
    
    <td width="56"><div align="center">列印紙本</div></td>
    <td width="20"><div align="center">V</div></td>
  </tr>
  <?php
     //此大段主要為列出表格完整內容
  require 'connect.php';
  require 'func/apply_func.php';
  $result=mysql_query('select * from dayoff where applyer="'.$_SESSION['usernumber'].'" order by number desc');
	    while($row = mysql_fetch_array($result)){
			$applydate=$row['applydate'];
			$startdate=$row['startdate'];
			$enddate=$row['enddate'];
			$days=$row['dayoff'];
			$cat=$row['cat'];
			$cat_name="";
			$supervisor=$row['supervisor']; //主管號碼
			$supervisor_name="";
			$status=$row['status'];
			$serial=$row['number'];
			$comment=$row['comment'];
			$agent=get_user_chinese_name($row['jobagent']);
			//以下二行主管取得名字
			$result2=mysql_query('select * from user where usernumber="'.$supervisor.'"');
			while($row2=mysql_fetch_array($result2)){ $supervisor_name=$row2['username'];}
			//以下二行取得假種中文
			$result2=mysql_query('select * from cat_dayoff where serial="'.$cat.'"');
			while($row2=mysql_fetch_array($result2)){ $cat_name=$row2['cat'];}
			
        echo '<tr>';
		echo '<td><div align="center">'.$applydate.'</div></td>';
		echo '<td><div align="center">'.$startdate.' ~ '.$enddate.'</div></td>';
		echo '<td><div align="center">'.$days.'</div></td>';
		echo '<td><div align="center">'.$cat_name.'</div></td>';
		echo '<td><div align="center">'.$supervisor_name.'</div></td>';
		echo '<td><div align="center">'.$comment.'</div></td>';		
		echo '<td><div align="center">'.$status.'</div></td>';
		echo '<td><input type="button" name="print" id="print" value="列印" onclick="printpage(\''.$startdate.'\',\''.$enddate.'\',\''.$_SESSION['username'].'\',\''.$days.'\',\''.$cat_name.'\',\''.$agent.'\',\''.$applydate.'\')" /></td>';
		echo '<td><input type="checkbox" id="p[]" name="p[]" value="'.$serial.'" /> </td>';
		echo '</tr>';
   	   }
	   ?>
  
</table>

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>


</div>
<!-- end #container --></div>
<script>
 function printcheck(){
	 var box= new Array();
	 $('input:checkbox:checked[name="p"]').each(function(i) { box[i] = this.value; });
	 
	// window.open('', 'ppap');
	 $.ajax({
        url: "printcheck.php",
        data: {
            serial:box
        },
        type: "POST",
        dataType: "html",
        success: function() {
          console.log("success");
		  
        },
        error: function() {
             $('#msg').text("更新失敗");
        }
        
    });
	 
	 }
 function printpage(start,end,u_name,days,cat,jobagent,today){
		//var bodyHtml=document.body.innerHTML;
		//document.body.innerHTML=html;
		//window.print();
		//document.body.innerhtml=bodyHtml;
		//var start,end,u_name,days,cat,jobagent,today;
		//start=$( "#startdate" ).val();
		//end=$( "#enddate" ).val();
		//u_name=$( "#username" ).html();
		//days=$( "#days" ).val();		
		//cat=$( "#cat :selected" ).text();
		//jobagent=$( "#agent :selected" ).text();
		//today=$( "#todayDate" ).html();
		var addr='print.php?start='+start+'&end='+end+'&username='+u_name+'&days='+days+'&cat='+cat+'&agent='+jobagent+'&today='+today;
		console.log(addr);
		window.open(addr,'printer','width=900,height=500');
		}
        </script>
</body>
</html>
