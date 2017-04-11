<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class jeton extends Controller
{
    //

	public function control()
	{
		ini_set('error_reporting', E_ALL);
		define('API_KEY','368144050:AAGpp3CY_ZHDaPqdZKPEU3_PSnp9lUn11BQ');

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

		$update = json_decode(file_get_contents('php://input'));

		$chatId = $update->message->chat->id;
		$messageText=$update->message->text;
		$today="1396";
		makeHTTPRequest('sendMessage',[
	        'chat_id'=>$chatId,
	        'text'=>"امروز: ".$today."\nامتحان بعدی شما: ریاضی2\nروز باقیمانده: 4 روز",
	        'reply_markup'=>json_encode([
	            'inline_keyboard'=>[
	                [
	                    ['text'=>"امتحانات من",'callback_data'=>'2']
	                ],
	                [
	                    ['text'=>"لیست امتحانات",'callback_data'=>'3']
	                ],
	                [
	                	['text'=>"تنظیمات",'callback_data'=>'4']
	                ],
	                [
	                    ['text'=>"معرفی به دوستان",'switch_inline_query'=>'سلام، این ربات به نظرم مفید بود خواستم بهت معرفیش کنم']
	                ]
	            ]
	        ])
	    ]);
	}

}
