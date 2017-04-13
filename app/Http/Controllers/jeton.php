<?php

namespace App\Http\Controllers;

use App\Juser;
// use \App\myclass\jdf;
use App\myclass\jalali;

class jeton extends Controller
{


	public function control()
	{
		ini_set('error_reporting', E_ALL);
		define('API_KEY','368144050:AAGpp3CY_ZHDaPqdZKPEU3_PSnp9lUn11BQ');


		// include(app_path() . '/../myclass/jdf.php');
		// $date=new \App\myclass\jdf\date;

		$today =jdf::hello();

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
		$today="111";
		


		$user_id=$update->message->from->id;
		$fname=$update->message->from->first_name;
		$lname=$update->message->from->last_name;
		$username=$update->message->from->username;


		if(isset($update->callback_query))
		{

		}else
		{
			if($messageText=="/start")
			{
				Juser::firstOrCreate([
					'user_id' => $user_id,
					'fname'=>$fname,
					'lname'=>$lname,
					'username'=>$username,
					]);
			}

			// if($messageText=="/setUsername")
			// {
			// 	$juser=	Juser::find($user_id);
			// 	$juser->jusername=$messageText;
			// 	$juser->save();
			// }
			// if($messageText=="/setPassword")
			// {
			// 	$juser=	Juser::find($user_id);
			// 	$juser->jpassword=$messageText;
			// 	$juser->save();
			// }

			makeHTTPRequest('sendMessage',[
		        'chat_id'=>$chatId,
		        'text'=>"امروز: ".$today,
		        'reply_markup'=>json_encode([
		            'inline_keyboard'=>[
		                [
		                    ['text'=>"غذای امروز",'callback_data'=>'2']
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

}
