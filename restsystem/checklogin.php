<?php
//檢查登入與否
//沒有登入就回去login
session_start();
if(!isset($_SESSION['username'])){
	session_destroy();
    header('Location: login.php');
}else if($_SESSION['system']!='dayoff'){
	session_destroy();
    header('Location: login.php');
	
	}

?>