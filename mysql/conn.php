<?php 
header('Content-Type:text/html; charset=utf-8');

$server_name="localhost"; //数据库服务器名称 
$mysql_username="root"; // 连接数据库用户名 
$mysql_password=""; // 连接数据库密码
$mysql_database="erp"; // 数据库的名字 
// 连接数据库 
$conn = mysql_connect($server_name,$mysql_username,$mysql_password) or die("数据库链接错误".mysql_error());
// 选择数据库
mysql_select_db($mysql_database,$conn) or die("数据库访问错误".mysql_error());

?>