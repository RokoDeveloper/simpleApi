<?php

class Api_Main extends Api
{

	function __construct()
	{
		$this->model = new Model_Main();
	}

	function action_index()
	{
	  echo 'Hello World!';
	}
}
