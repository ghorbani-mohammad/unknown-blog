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

		include(app_path() . '/../public/jdf/jdf.php');
		$today = jdate('l j F');

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
		\Log::info(print_r($update,true));
		
		if(isset($update->callback_query))
		{
			$item=$update->callback_query->data;
			$chatId = $update->callback_query->message->chat->id;
	        $messageId = $update->callback_query->message->message_id;
	        $callbackQueryId=$update->callback_query->id;

	        makeHTTPRequest('answerCallbackQuery',['callback_query_id'=>$callbackQueryId]);

			switch ($item) 
			{
				case '1':
					makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
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
				break;

				case '2':
					makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
				        'text'=>"لیست امتحانات من",
				        'reply_markup'=>json_encode([
				            'inline_keyboard'=>[
				                [
				                    ['text'=>"ریاضی2",'callback_data'=>'11']
				                ],
				                [
				                    ['text'=>"محاسبات",'callback_data'=>'21']
				                ],
				                [
				                	['text'=>"معادلات دیفرانسیل",'callback_data'=>'31']
				                ],
				                [
				                    ['text'=>"طراحی اجزا کامپیوتر",'callback_data'=>'41']
				                ],
				                [
				                    ['text'=>"بازگشت",'callback_data'=>'1']
				                ]
				            ]
				        ])
				    ]);
				break;

				case '3':
					# code...
				break;

				default:
					# code...
					break;
			}

		}else
		{
			$chatId = $update->message->chat->id;
			$messageText=$update->message->text;

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
}
