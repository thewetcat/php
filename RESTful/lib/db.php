<?php
/**
 * 连接数据库并返回数据连接句柄
 */
$pdo = new PDO('mysql:host=localhost;dbname=restful','root','');
return $pdo;