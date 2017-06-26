<?php

class Api {

	public $model;


	public function print_message($text,$error = false)
	{
		if($error)
		{
			$msg['status'] = 'error';
			$msg['msg'] = $text;
			header("HTTP/1.1 500 Internal Server Error");
			echo json_encode($msg);
			exit();
		} else {
			$msg['status'] = 'Success';
			$msg['msg'] = $text;
			echo json_encode($msg);
		}
	}

	public function redirect($new_url)
	{
	  header('Location: ' . $new_url);
		exit();
	}

	static function setUrlParams($add = array(),$rm = array())
{
	$resultUrl = "";
	$url = explode("?",$_SERVER["REQUEST_URI"]);
	$dataParams = array();
	if(isset($url[1]))
	{
		$params = explode("&",$url[1]);
		foreach($params as $current)
		{
			$data = explode("=",$current);
			if(in_array($data[0],$rm))
			{
				continue;
			}
			$dataParams[] = $data[0] . "=" . (isset($data[1]) ? $data[1] : "");
		}
	}
	else
	{
		$resultUrl = $url[0];
	}

	foreach($add as $current)
	{
		$dataParams[] = $current;
	}

	$resultUrl .= (count($dataParams) > 0 ? "?" . implode("&",$dataParams) : "" );

	return $resultUrl != '' ? $resultUrl : $url[0];
}


}
