<?php
/**
 * 
 */
class User{
	// 数据库连接句柄
	private $_db;

	// 构造方法
	public function __construct($_db){
		$this->_db = $_db;
	}

	// 用户登录
	public function login($username, $password){
		
	}

	// 用户注册
	public function register($username, $password){
		return $this->_isUsernameExists($username);
	}

	// 检测用户名是否存在
	private function _isUsernameExists($username){
		$sql = 'SELECT * FROM `user` WHERE `username`=:username';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return !empty($result);
	}
}