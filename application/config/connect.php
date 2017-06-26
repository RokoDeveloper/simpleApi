<?php
ini_set('session.gc_maxlifetime', 10);
ini_set('session.cookie_lifetime', 10);
define('_HOST',':host=localhost');
define('_DB','dgstarcom_test');
define('_DBUSER','roman_test');
define('_DBPASSWORD','Ctvp4~77');
define('_DB_TABLE_PREFIX','');


class DBQuery
{
	public static $connection = null;
	var $queryResult;

	function __construct($sql,$params = array())
	{
		if(empty(self::$connection))
		{
			self::openConnection();
		}
		$sql = self::parseQuery($sql);
		//print $sql;
		$this->queryResult = self::$connection->prepare($sql);
		if(is_array($params))
    {
			foreach($params as $key=>$value)
			{
				$this->queryResult->bindValue($key,$value);
			}
		}
		$this->queryResult->execute();
	}

	static function parseQuery($sql)
	{
		return str_replace("#__",_DB_TABLE_PREFIX,$sql);
	}

	static function openConnection()
	{
		try
		{
			self::$connection = new PDO("mysql"._HOST.";dbname=" . _DB, _DBUSER, _DBPASSWORD);
			self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			self::$connection->query("set names utf8");
		}
		catch(PDOException $e)
		{
			global $app;
			$app->errors[] = $e->getMessage();
			return false;
		}

	}
	static function closeConnection()
	{
		$db = null;
	}

	function fetch($fetchStyle = PDO::FETCH_ASSOC)
	{
		if(!empty($this->queryResult))
		{
			return  $this->queryResult->fetch($fetchStyle);
		}
		else
		{
			return false;
		}
	}

}
