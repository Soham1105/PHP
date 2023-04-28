<?php
namespace app\src\models;
use PDO;
class Database{
	private $pdo;
	public static Database $database = null;
	public function __construct(){
		$this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=Feedback",'sachin','_Sachine@123');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		self::$database = $this;
	}
	public function getSem($keyword=''){
		
	}
}