<?php

class Api_Say_Number_Ru extends Api
{

	function action_index()
	{
    if(!empty($_POST))
    {
      foreach($_POST as $key => $value)
      {
        echo $value;
      }
    } else {
      $this->print_message('Empty POST',true);
    }
	}
}
