<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>請假單</title>
<link type="text/css" href="js/jquery-ui.structure.min.css" rel="stylesheet" />   
 <link type="text/css" href="js/jquery-ui.min.css" rel="stylesheet" /> 
  <link rel="stylesheet" href="js/images/style.css">
  <link rel="stylesheet" href="js/jquery-ui-timepicker-addon.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datepicker-zh-TW.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<style type="text/css">
<!--
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background-color:#CCC;
	margin: 0;
	padding: 0;
	color: #000;
}

/* ~~ 元素/標籤選取器 ~~ */
ul, ol, dl { /* 由於瀏覽器之間的差異，最佳作法是在清單中使用零寬度的欄位間隔及邊界。為了保持一致，您可以在這裡指定所要的量，或在清單包含的清單項目 (LI、DT、DD) 上指定所要的量。請記住，除非您寫入較為特定的選取器，否則在此執行的作業將重疊顯示到 .nav 清單。 */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* 移除上方邊界可以解決邊界可能從其包含的 Div 逸出的問題。剩餘的下方邊界可以保持 Div 不與接在後面的元素接觸。 */
	padding-right: 15px;
	padding-left: 15px; /* 將欄位間隔加入至 Div 內元素的兩側 (而不是 Div 本身)，即可不需執行任何方塊模型的計算作業。具有側邊欄位間隔的巢狀 Div 也可當做替代方法。 */
}
a img { /* 這個選取器會移除某些瀏覽器在影像由連結所圍繞時，影像周圍所顯示的預設藍色邊框 */
	border: none;
}
/* ~~ 網站連結的樣式設定必須保持此順序，包括建立滑過 (Hover) 效果的選取器群組在內。~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* 除非您要設定非常獨特的連結樣式，否則最好提供底線，以便快速看出 */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* 這個選取器群組可以讓使用鍵盤導覽的使用者，也和使用滑鼠的使用者一樣擁有相同的滑過體驗。 */
	text-decoration: none;
}

/* ~~ 這個固定寬度的容器環繞著其他 Div ~~ */
.container {
	width: 900px;
	background-color: #FFF;
	margin: 0 auto; /* 兩側的自動值與寬度結合後，版面便會置中對齊 */
}

/* ~~ 頁首沒有指定的寬度，而會橫跨版面的整個寬度。頁首包含影像預留位置，必須由您自己的連結商標加以取代 ~~ */
.header {
	background-color: #ADB96E;
}

/* ~~ 這是版面資訊。~~ 

1) 欄位間隔只會置於 Div 的頂端或底部。此 Div 內的元素在兩側會有欄位間隔，可讓您不需進行「方塊模型計算」。請記住，如果對 Div 本身加入任何側邊的欄位間隔或邊框，在計算「總」寬度時，就會將這些加入您定義的寬度。您也可以選擇移除 Div 中元素的欄位間隔，然後在其中放置沒有寬度的第二個 Div，並依設計所需放置欄位間隔。

*/

.content {

	padding: 10px 0;
}

/* ~~ 頁尾 ~~ */
.footer {
	padding: 10px 0;
	background-color: #CCC49F;
}

/* ~~ 其他 float/clear 類別 ~~ */
.fltrt {  /* 這個類別可用來讓元素在頁面中浮動，浮動的元素必須位於頁面上相鄰的元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 這個類別可用來讓元素在頁面左方浮動，浮動的元素必須位於頁面上相鄰的元素之前。 */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* 這個類別可放置在 <br /> 或空白的 Div 上，當做接在 #container 內最後一個浮動 Div 後方的最後一個元素 (如果從 #container 移除或取出 #footer) */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
</style></head>

<body>

<div class="container" align="center">
  <div class="content" >
  <?php
  	require 'myjs/myjquery.php';
	require 'connect.php';
  require 'func/apply_func.php';
  
	date_default_timezone_set('Asia/Taipei');
  $serial=$_POST['serial'];
  $serial=$_POST['p'];
  foreach($serial as $n){
	  $str='select * from dayoff where number=\''.$n.'\'';
	  $result=mysql_query($str);
	  while($row = mysql_fetch_array($result)){
		  $applyer=$row['applyer'];
		  $startdate=$row['startdate'];
		  $enddate=$row['enddate'];
		  $cat=$row['cat'];
		  $jobagent=$row['jobagent'];
		  $applydate=$row['applydate'];
		  $dayoff=$row['dayoff'];
		  
		  $applyer=get_user_chinese_name($applyer);
		  $jobagent=get_user_chinese_name($jobagent);
		  $cat=get_catname($cat);
		  
		  $start_m=explode('-',$startdate);
	  $end_m=explode('-',$enddate);
	  $today_m=explode('-',$applydate);
	  //$end_mingo->modify("-1911 year");
	  //$today_mingo->modify("-1911 year");
	  $start_mingo=$start_m[0]-1911;
	  $end_mingo=$end_m[0]-1911;
	  $today_mingo=$today_m[0]-1911;
		 // echo '<br>';
		  echo '<table width="800" border="1"  cellpadding="2" style="background-color:#FFF">
      <tr>
        <td height="71" colspan="2"><p align="center" style="font-size:28px" ><strong >XXXX股份有限公司 </strong></p>
        <p align="center" style="font-size:24px"><strong>請假單</strong></p></td>
       
      </tr>
      <tr>
        <td width="383" id="applyer">申請人:'.$applyer.'</td>
        <td width="397">職稱:</td>
      </tr>
      <tr>
        <td height="41" colspan="2" id="offtime" >請假時間: 自民國'.$start_mingo.'年'.$start_m[1].'月'.str_replace(" ","日  ",$start_m[2]).'<br>&emsp;&emsp;&emsp;&emsp;&emsp;至民國 '.$end_mingo.'年 '.$end_m[1].'月'. str_replace(" ","日  ",$end_m[2]).' 共 '.$dayoff.' 天'.'</td>
        
      </tr>
      <tr>
        <td height="41" id="cat">假別:'.$cat.'</td>
        <td id="agent">職務代理人:'.$jobagent.'&nbsp;(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <font size=1>請代理人親簽</font>)</td>
      </tr>
      <tr>
        <td height="41">單位主管簽名:</td>
        <td>主管簽名:</td>
      </tr>
      <tr>
        <td height="41" colspan="2" id="applydate" align="center">申請日期:民國 '.$today_mingo.' 年 '.$today_m[1].' 月 '.$today_m[2].' 日'.'</td>
        
      </tr>
    </table>';
		  }
	  echo '<br>';
	  }
  ?>
    
    
  <script>
	function printHtml(html){
		var bodyHtml=document.body.innerHTML;
		document.body.innerHTML=html;
		window.print();
		//document.body.innerhtml=bodyHtml;
		}
		function onprint(){
			var html=$('.content').html();
			printHtml(html);
			}
	</script>
    </div>
    <form name="form1" method="post" action="">
      <input type="submit" name="printout" id="printout" value="列印" onClick="onprint()" >
  </form>
 <form name="form1" method="post" action="http://192.168.1.9/restsystem_test/applyhistory.php">
      <input type="submit" name="goback" id="goback" value="返回"  >
  </form>
</body>
</html>
