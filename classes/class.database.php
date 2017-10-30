<?php
class DB_Connection{
	private static $db_host;
	private static $db_name;
	private static $db_user;
	private static $db_pass;
	private static $db_port;
	private static $db_driver;
	private static $db_connection;
	private static $dsn;
	private static $set_dsn;
	private $sql;
	private $sql_query;
	
	private static $pdo_conn = null;
	
	public function __construct($conn_file=""){
		//echo "-----------------------CONSTRUCTOR INITIALIZED---------------------------<br />";
		$conn_param				=	$this->getProperties($conn_file);
		///self::$db_connection		=	trim($conn_param['DB_DBASE']);
		self::$db_driver			=	trim($conn_param['DB_DRIVER']);
		self::$db_host				=	trim($conn_param['DB_HOST']);
		self::$db_name				=	trim($conn_param['DB_NAME']);
		self::$db_user				=	trim($conn_param['DB_USER']);
		self::$db_pass				=	trim($conn_param['DB_PASS']);
		self::$db_port				=	trim($conn_param['DB_PORT']);
		$dsn_val						=	$this->getDSN(self::$db_driver);
		self::$set_dsn				=	$dsn_val;
	}
	
	public static function pr($arr){
		echo "<pre>";
		print_r($arr);
	}
	
	public function getProperties($filename){
		$data_arr		=	array();
		$conn_data	=	array();
		$file 			= fopen($filename,"r") or die("Error in opening file");
		while(!feof($file))
	  {
			$read_file = fgets($file);
			if($read_file[0] === '#' || $read_file[0] === ''){
				continue;
			}
			$split_prop	= explode("\n",$read_file);
	
			foreach(array_filter($split_prop) as $key=>$val){
				$data_arr[]	=	explode(":",$val);
				foreach($data_arr as $data){
					
					$conn_data[$data[0]]	=	$data[1];
				}
			}
	  }
		//DB_Connection::pr($conn_data);
		return array_filter($conn_data);
	}
	
	public function getDSN($driver){
		self::$dsn	=	$driver.":host=".self::$db_host.";dbname=".self::$db_name.";port=".self::$db_port;
		return self::$dsn;
	}
	
	public static function connect(){
		$pdo_option	=	array(
			PDO::ATTR_ERRMODE	=> PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE	=>	PDO::FETCH_ASSOC
		);
		if(null == self::$pdo_conn){
			try{
				self::$pdo_conn	=	new PDO(self::$set_dsn,self::$db_user,self::$db_pass,$pdo_option);
				//echo "connected to databse<br />";
			}catch(PDOException $e){
				echo "Error !! : ".$e->getMessage();
			}
		}
		return self::$pdo_conn;
	}
	
	public static function disconnect(){
		self::$pdo_conn	=	null;
	}
}
?>