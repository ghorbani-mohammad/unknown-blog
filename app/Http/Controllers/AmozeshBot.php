<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AmozeshBot extends Controller
{
    //
    public function controll()
    {
    	ini_set('error_reporting', E_ALL);
		define('API_KEY','313661129:AAGVxrwy2DDw7OQjzJI6AftzD-8SO2Cyhvo');

		function makeHTTPRequest($method,$datas=[])
		{
		    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
		    $ch = curl_init();
		    curl_setopt($ch,CURLOPT_URL,$url);
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
		    $res = curl_exec($ch);
		    if(curl_error($ch))
		    {
		        var_dump(curl_error($ch));
		    }else
		    {
		        return json_decode($res);
		    }
		}

		// Fetching UPDATE
		$update = json_decode(file_get_contents('php://input'));
		  
		$chat_id = $update->message->chat->id;

		makeHTTPRequest('sendMessage',[
			'chat_id'=>$chat_id,
			'text'=>"Hello",
		]);
		    
    }
}
