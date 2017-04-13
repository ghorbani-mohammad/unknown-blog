<?php

namespace App\Http\Controllers;

use App\Juser;
use App\JUserState; 

class jeton extends Controller
{


	public function control()
	{
		ini_set('error_reporting', E_ALL);
		define('API_KEY','368144050:AAGpp3CY_ZHDaPqdZKPEU3_PSnp9lUn11BQ');

		include(app_path() . '/Myclasses/Jalali.php');
        $today= jdate('l j F'); 

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

		if(isset($update->callback_query))
		{
			\Log::info("call_back: ".$update->callback_query->data);

			$item=$update->callback_query->data;
			$chatId = $update->callback_query->message->chat->id;
			
	        $messageId = $update->callback_query->message->message_id;
	        $callbackQueryId=$update->callback_query->id;
	        makeHTTPRequest('answerCallbackQuery',['callback_query_id'=>$callbackQueryId]);

	        switch ($item) {
	        	case '1':
	        		\Log::info("switch 1");
	        		makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
				        'text'=>"امروز: ".$today,
				        'reply_markup'=>json_encode([
				            'inline_keyboard'=>[
				                [
				                    ['text'=>"غذای امروز",'callback_data'=>'2']
				                ],
				                [
				                	['text'=>"ژتون من",'callback_data'=>'2']
				                ],
				                [
				                    ['text'=>"معرفی به دوستان",'switch_inline_query'=>'سلام، این ربات به نظرم مفید بود خواستم بهت معرفیش کنم']
				                ]
				            ]
				        ])
				    ]);
	        	break;
	        	
	        	case '2':
		        	\Log::info("switch 2");
	        		makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
				        'text'=>"اعتبار شما: ".$today,
				        'reply_markup'=>json_encode([
				            'inline_keyboard'=>[
				                [
				                    ['text'=>"غذای امروز",'callback_data'=>'2']
				                ],
				                [
				                	['text'=>"اطلاعات کارت",'callback_data'=>'3']
				                ],
				                [
				                    ['text'=>"بازگشت",'callback_data'=>'1']
				                ]
				            ]
				        ])
				    ]);
        		break;
        		case '3':
		        	\Log::info("switch 3");
	        		makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
				        'text'=>"اعتبار شما: ".$today,
				        'reply_markup'=>json_encode([
				            'inline_keyboard'=>[
				                [
				                    ['text'=>"نام کاربری",'callback_data'=>'4']
				                ],
				                [
				                	['text'=>"رمز عبور",'callback_data'=>'5']
				                ],
				                [
				                    ['text'=>"بازگشت",'callback_data'=>'2']
				                ]
				            ]
				        ])
				    ]);
        		break;
        		case '4':
		        	\Log::info("switch 4");
		        	$user_id = $update->callback_query->from->id;
		        	JUserState::create('user_id' => $user_id,
									   'state'=>$'id');
	        		makeHTTPRequest('sendMessage',[
				        'chat_id'=>$chatId,
				        'text'=>"لطفا نام کاربر خود را ارسال کنید",
				    ]);
        		break;
        		case '5':
		        	\Log::info("switch 5");
	        		makeHTTPRequest('editMessageText',[
				        'chat_id'=>$chatId,
				        'message_id'=>$messageId,
				        'text'=>"اعتبار شما: ".$today,
				        'reply_markup'=>json_encode([
				            'inline_keyboard'=>[
				                [
				                    ['text'=>"نام کاربری",'callback_data'=>'4']
				                ],
				                [
				                	['text'=>"رمز عبور",'callback_data'=>'5']
				                ],
				                [
				                    ['text'=>"بازگشت",'callback_data'=>'2']
				                ]
				            ]
				        ])
				    ]);
        		break;
	        }

		}else
		{

			\Log::info("not call_back");
			$chatId = $update->message->chat->id;
			$messageText=$update->message->text;

			$user_id=$update->message->from->id;
			$fname=$update->message->from->first_name;
			$lname=$update->message->from->last_name;
			$username=$update->message->from->username;


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
		                    ['text'=>"غذای امروز",'callback_data'=>'1']
		                ],
		                [
		                	['text'=>"ژتون من",'callback_data'=>'2']
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
