<?php

namespace App\Http\Controllers;

use App\Juser;
use App\Juserstate; 

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
			$user_id = $update->callback_query->from->id;
			
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
						['text'=>"برنامه غذایی",'callback_data'=>'2']
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
					'text'=>"امروز: ".$today,
					'reply_markup'=>json_encode([
						'inline_keyboard'=>[
						[
						['text'=>"ورود",'callback_data'=>'10']
						],
						[
						['text'=>"کارت من",'callback_data'=>'3']
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
				$user=Juser::find($user_id);
				$jusername=$user->jusername;
				$jpassword=$user->jpassword;
				$jusername=(!is_null($jusername)?"ثبت شده است ✅":"ثبت نشده است ❌");
				$jpassword=(!is_null($jpassword)?"ثبت شده است ✅":"ثبت نشده است ❌");
				makeHTTPRequest('editMessageText',[
					'chat_id'=>$chatId,
					'message_id'=>$messageId,
					'text'=>"نام کاربری: ".$jusername."\nرمز عبور: ".$jpassword,
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
				\Log::info("switch4: getting username");
				$state=JUserState::updateOrCreate(['user_id' => $user_id],['state'=>'id']);
				makeHTTPRequest('sendMessage',[
					'chat_id'=>$chatId,
					'text'=>"لطفا نام کاربری خود را ارسال کنید",
					]);
				break;
				case '5':
				\Log::info("switch5: getting password");
				$state=JUserState::updateOrCreate(['user_id' => $user_id],['state'=>'pa']);
				makeHTTPRequest('sendMessage',[
					'chat_id'=>$chatId,
					'text'=>"لطفا رمز عبور خود را ارسال کنید",
					]);
				break;
				case '10':
				\Log::info("switch10: vorod");
				$user=Juser::find($user_id);
				if($user->jusername==NULL||$user->jpassword==NULL)
				{
					\Log::info("switch10: vorod->no id or pass");
					makeHTTPRequest('sendMessage',[
					'chat_id'=>$chatId,
					'text'=>"نام کاربری یا رمز عبور شما تعیین نشده است لطفا به منوی قبل باز گردید و با ورود به  <<کارت من>> آنها را تعیین کنید",
					'reply_markup'=>json_encode([
						'inline_keyboard'=>[

							[
								['text'=>"بازگشت",'callback_data'=>'2']
							]
						]
						])
					]);
				}else
				{
					\Log::info("switch10: vorod->Trying to get capthca and other fields");
					$pyPath = 'python3';
					$appPath=app_path().'/loginStep1.py';
					$config='2>&1'; //Redirect stderr to stdout, so you can see errors
					$command="$pyPath $appPath $config $user_id";
					exec($command, $out, $status);
					if($out[0]=="Success")
					{
						\Log::info("switch10: vorod->Getting captcha and other fields");
						makeHTTPRequest('sendPhoto',[
							'chat_id'=>$chatId,
							'photo'=>$out[1],
							'caption'=>'کد امنیتی بالا را وارد کنید'
						]);
						JUserState::updateOrCreate(['user_id' => $user_id],['state'=>'lo']);

					}else
					{
						\Log::info("switch10: vorod->Problem to getting captcha and other fields");
						makeHTTPRequest('editMessageText',[
						'chat_id'=>$chatId,
						'message_id'=>$messageId,
						'text'=>"متاسفانه مشکلی پیش آمده است لطفا مجددا تلاش کنید",
						'reply_markup'=>json_encode([
							'inline_keyboard'=>[
								[
									['text'=>"بازگشت",'callback_data'=>'2']
								]
							]
							])
						]);
					}
					
				}
				break;
			}

		}else
		{

			\Log::info("no call_back data");
			$chatId = $update->message->chat->id;
			$messageText=$update->message->text;

			$user_id=$update->message->from->id;
			$fname=$update->message->from->first_name;
			$lname=$update->message->from->last_name;
			$username=$update->message->from->username;


			if($messageText=="/start")
			{
				\Log::info("text message:start command");
				Juser::firstOrCreate([
					'user_id' => $user_id,
					'fname'=>$fname,
					'lname'=>$lname,
					'username'=>$username,
					]);
				JUserState::destroy($user_id);
				makeHTTPRequest('sendMessage',[
					'chat_id'=>$chatId,
					'text'=>"امروز: ".$today,
					'reply_markup'=>json_encode([
						'inline_keyboard'=>[
						[
						['text'=>"برنامه غذایی",'callback_data'=>'1']
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
			}else
			{
				\Log::info("text message:no command");
				if(JUserState::where('user_id',$user_id)->count()!=0)
				{
					\Log::info("we have state for this user");
					if(is_numeric($messageText))
					{
						$state = JUserState::find($user_id)->state;
						\Log::info("state: ".$state);
						if($state=='id')
						{
							if(strlen($messageText)>10)
							{
								\Log::info("id grater than 10");
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"نام کاربری باید کمتر از 11 کاراکتر باشد. مجددا تلاش کنید",
								]);
							}
							elseif(strlen($messageText)<5)
							{
								\Log::info("id less than 5");
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"نام کاربری شما باید حداقل 5 کاراکتر باشد",
								]);
							}
							else
							{
								$user=Juser::where('user_id',$user_id)->update(['jusername'=>$messageText]);
								Juserstate::destroy($user_id);
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"نام کاربری شما ثبت شد",
									'reply_markup'=>json_encode([
										'inline_keyboard'=>[
										[
										['text'=>"بازگشت",'callback_data'=>'3']
										],
										]
										])
								]);
							}
						}
						elseif ($state=='pa')
						{
							if(strlen($messageText)>25)
							{
								\Log::info("pass grater than 25");
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"رمز عبور شما طولانی است. لطفا آن را تغییر دهید و سپس مجددا تلاش کنید",
									]);
							}
							elseif(strlen($messageText)<2)
							{
								\Log::info("pass less than 2");
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"رمز عبور شما کوتاه است",
								]);
							}
							else
							{
								$user=Juser::where('user_id',$user_id)->update(['jpassword'=>$messageText]);
								Juserstate::destroy($user_id);
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"رمز عبور شما ثبت شد",
									'reply_markup'=>json_encode([
										'inline_keyboard'=>[
										[
										['text'=>"بازگشت",'callback_data'=>'3']
										],
										]
										])
									]);
							}
						}
						elseif ($state=='lo') 
						{
							if(strlen($messageText)==4)
							{
								\Log::info("Getting Captcha Code from user");
								$user=Juser::find($user_id);
								$captcha=$messageText;
								$pyPath = 'python3';
								$appPath=app_path().'/loginStep2.py';
								$config='2>&1'; //Redirect stderr to stdout, so you can see errors
								$command="$pyPath $appPath $config $user_id $captcha $user->jusername $user->jpassword";
								exec($command, $out, $status);
								// \Log::info($out);
								$out=json_decode($out[0],true);
								$out=array_values($out);
								if($out[0]=="Success")
								{
									\Log::info("Successful Login To Jeton");
									makeHTTPRequest('sendMessage',[
										'chat_id'=>$chatId,
										'text'=>$out[1]." عزیز خوش آمدید\nاعتبار شما: ".$out[2]." ریال",
										'reply_markup'=>json_encode([
										'inline_keyboard'=>[
												[
													['text'=>"رزرو غذا",'callback_data'=>'11']
												],
												[
													['text'=>"لغو غذا",'callback_data'=>'12']
												],
												[
													['text'=>"بازگشت",'callback_data'=>'2']
												],
											]
										])
									]);
								}else
								{
									\Log::info("Failed Login To Jeton");
									makeHTTPRequest('sendMessage',[
										'chat_id'=>$chatId,
										'text'=>"ورود با مشکل مواجه شد. لطفا مجددا تلاش کنید در صورت تکرار نام کاربری یا رمز عبور خود را بررسی کنید",
										'reply_markup'=>json_encode([
											'inline_keyboard'=>[
												[
													['text'=>"بازگشت",'callback_data'=>'2']
												]
											]
										])
									]);
								}
							}else
							{
								\Log::info("Captcha Code is not 4 character");
								makeHTTPRequest('sendMessage',[
									'chat_id'=>$chatId,
									'text'=>"کد امنیتی باید 4 رقم باشد",
								]);
							}

						}
					}else
					{
						makeHTTPRequest('sendMessage',[
							'chat_id'=>$chatId,
							'text'=>"نام کاربری یا کلمه عبور فقط می تواند عدد باشد. مجددا تلاش کنید",
							]);
					}
				}else
				{
					\Log::info("we don't have state for this user");
					makeHTTPRequest('sendMessage',[
						'chat_id'=>$chatId,
						'text'=>"امروز: ".$today,
						'reply_markup'=>json_encode([
							'inline_keyboard'=>[
							[
							['text'=>"برنامه غذایی",'callback_data'=>'1']
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
	}

}
