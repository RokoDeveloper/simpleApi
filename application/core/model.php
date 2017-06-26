<?php
require_once 'application/config/connect.php';

class Model
{

	public function db_get_one($query,$params = array())
	{
	  $query = DBQuery::parseQuery($query);
		$db = new DBQuery($query,$params);
		$row = $db->fetch(PDO::FETCH_BOTH);
		return isset($row[0]) ? $row[0] : "";
  }

	public function db_query($query,$params = array(),$last_id = false)
  {

			$query = DBQuery::parseQuery($query);


			$result = array();


			$db = new DBQuery($query,$params);

			while($r = $db->fetch())
			{
				array_push($result,$r);
			}

			if($last_id)
			{
				$result = DBQuery::$connection->lastInsertId();
			}


			return $result;
	}

}
