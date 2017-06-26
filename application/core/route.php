<?php

/*
url for call api method - /api/@methodName@
*/

class Route
{

	static function start()
	{
		//Strict definition of ways
		$api_path = array(
			'sayhelloinlanguage' => 'hello_lang',
			'saynumberinenglish' => 'say_number',
			'saynumberinrussian' => 'say_number_ru'
		);


		$current_uri = explode('?', $_SERVER['REQUEST_URI']);
		$routes = explode('/', $current_uri[0]);


		if ( !empty($routes[2]) && isset($api_path[strtolower($routes[2])]))
		{
			$api_name = $api_path[strtolower($routes[2])];
		} else {
			Route::Error();
		}

		if ( !empty($routes[3]) )
		{
			$action_name = $routes[3];
		} else {
			$action_name = 'index';
		}


		$model_name = 'Model_'.$api_name;
		$api_name = 'Api_'.$api_name;
		$action_name = 'action_'.$action_name;


		// add model api

		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path))
		{
			include "application/models/".$model_file;
		}

		// add api class
		$api_file = strtolower($api_name).'.php';
		$api_path = "application/api_method/".$api_file;
		if(file_exists($api_path))
		{
			include "application/api_method/".$api_file;
		}
		else
		{
			Route::Error();
		}

		$api = new $api_name;
		$action = $action_name;

		if(method_exists($api, $action))
		{
			//call api
			$api->$action();
		}
		else
		{
			Route::Error();
		}

	}

		static function Error()
		{
			header("HTTP/1.1 500 Internal Server Error");
			echo json_encode(array('code' => 402));
			exit();
	  }

}
