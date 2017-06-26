<?php

class Api_Hello_Lang extends Api
{
  public $lang;
  public $name;
  function __construct()
  {
    $this->check_param();
  }

	function action_index()
	{

    $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?' .
            'key=trnsl.1.1.20170626T064849Z.4c4a357f5003e4b3.367af7a391d6bc1b9d261e1abd62e3c11aed4d3b&' .
            'text=hello&' .
            'lang='.$this->lang.'&' .
            'format=plain&' .
            'options=1';

    $curlObject = curl_init();


    curl_setopt($curlObject, CURLOPT_URL, $url);

    curl_setopt($curlObject, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curlObject, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);

    $responseData = curl_exec($curlObject);

    curl_close($curlObject);

    if ($responseData === false) {
          $this->print_message('Problem with Yandex',true);
    }

    $translate = json_decode($responseData, true);
    if($translate['code'] == '502' || $translate['code'] == '501')
    {
      $this->print_message($translate['message'],true);
    } else {
        $msg = $translate['text'][0].' '.$this->name .'!';
        $this->print_message($msg);
    }



	}

  public function check_param()
  {
    //check exist
    $error['status'] = false;
    $error['msg'] = array();
    if(!isset($_POST['name']) || !isset($_POST['language']))
    {
      $this->print_message('Missing param',true);
    } else {
      $this->lang = strtolower($_POST['language']);
      $this->name = $_POST['name'];
    }

    //check length
    echo 1;
    if(strlen($this->name)  <= 2)
    {
      $error['status'] = true;
      $error['msg'][] = 'Name is too short';
    }

    if(strlen($this->name) > 15)
    {
      $error['status'] = true;
      $error['msg'][] = 'Name is too long';
    }
    //The name cannot contain consecutive repeating letters
    if((preg_match('/(.)\\1{1}/', $this->name)))
    {
      $error['status'] = true;
      $error['msg'][] = 'Name is invalid';
    }

    if($error['status'])
    {
      $msg = implode(',',$error['msg']);
        $this->print_message($msg,true);
    }
  }
}
