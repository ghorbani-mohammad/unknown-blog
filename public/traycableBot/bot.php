
<?php

ini_set('error_reporting', E_ALL);

define('API_KEY','338508236:AAGHjLdjmFwwytqVyksrIMNpPBQXlohAq6k');

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

if(isset($update->callback_query))
{  
        include('fee.php');

        $callback_query_id=$update->callback_query->id;
        makeHTTPRequest('answerCallbackQuery',['callback_query_id'=>$callback_query_id]);

        $chat_id = $update->callback_query->message->chat->id;
        $message_id = $update->callback_query->message->message_id;


        $data=$update->callback_query->data;
        if(strlen($data)==2)
            $item=$data;
        elseif(strlen($data)==4)
            $item=substr($data,2,2);
        elseif(strlen($data)==6)
            $item=substr($data,4,2);
        elseif(strlen($data)==8)
        {
            $item='100';
        }
        switch ($item) 
        {

            case '10':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"برای ادامه لطفا آیتم مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"قیمت ها",'callback_data'=>'11']
                            ],
                            [
                                ['text'=>"ارتباط با ما",'callback_data'=>'13'],
                                ['text'=>"فعالیت های ما",'callback_data'=>'12']
                            ]
                        ]
                    ])
                ]);
            break;


            case '11':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"برای ادامه لطفا آیتم مورد نظر خود را انتخاب کنید
                    ",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"سینی کابل",'callback_data'=>'20']
                            ],
                            [
                                ['text'=>"لوله فلکسی",'callback_data'=>'80'],
                                ['text'=>"لوله فولادی",'callback_data'=>'60']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'10']
                            ]
                        ]
                    ])
                ]);
            break;

            case '12':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"از جمله فعالیت های ما در زمینه ی تولید سینی کابل و نردبان کابل و همیچنین تهیه و توزیع لوله فولادی در سراسر کشور می باشد. برای کسب اطلاعات بیشتر در مورد محصولات ما میتوانید به سایت ما مراجعه کنید.",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"نردبان کابل",'url'=>'traycable.ir'],
                                ['text'=>"سینی کابل",'url'=>'traycable.ir']
                            ],
                            [
                                ['text'=>"لوله فولادی",'url'=>'traycable.ir']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'10']
                            ]
                        ]
                    ])
                ]);
            break;
            
            case '13':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"برای ارتباط با ما می توانید از راه های زیر استفاده کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"آدرس کارخانه",'callback_data'=>'3'],
                                ['text'=>"آدرس دفتر فروش",'callback_data'=>'3']
                            ],
                            [
                                ['text'=>"وبسایت",'callback_data'=>'3'],
                                ['text'=>"شماره های تماس",'callback_data'=>'3']
                            ],
                            [
                              ['text'=>"بازگشت",'callback_data'=>'10']  
                            ]
                        ]
                    ])
                ]);
            break;

            case '20':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"برای ادامه لطفا آیتم مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"سینی کابل گرم",'callback_data'=>'22'],
                                ['text'=>"سینی کابل سرد",'callback_data'=>'21']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'11']
                            ]
                        ]
                    ])
                ]);
            break;

            case '21': case '22':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"محصول مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"درب سینی",'callback_data'=>$item.'31'],
                                ['text'=>"سینی کابل",'callback_data'=>$item.'30']
                            ],
                            [
                                ['text'=>"زانویی،سه راهی،چهارراهی",'callback_data'=>$item.'33'],
                                ['text'=>"رابط سینی",'callback_data'=>$item.'32']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'20']
                            ]
                        ]
                    ])
                ]);
            break;

            case '30': case'31': case'32': case '33':
                $back=substr($data,0,2);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"عرض سینی را مشخص کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"20 سانت",'callback_data'=>$data.'42'],
                                ['text'=>"15 سانت",'callback_data'=>$data.'41'],
                                ['text'=>"10 سانت",'callback_data'=>$data.'40']
                            ],
                            [
                                ['text'=>"50 سانت",'callback_data'=>$data.'45'],
                                ['text'=>"40 سانت",'callback_data'=>$data.'44'],
                                ['text'=>"30 سانت",'callback_data'=>$data.'43']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            case '40': case'41': case'42': case '43':case '44':case '45':
                $back=substr($data,0,4);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"ضخامت ورق را مشخص کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"1.25 میل",'callback_data'=>$data.'51'],
                                ['text'=>"1 میل",'callback_data'=>$data.'50']
                            ],
                            [
                                ['text'=>"2 میل",'callback_data'=>$data.'53'],
                                ['text'=>"1.5 میل",'callback_data'=>$data.'52']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            case '100':
                $back=substr($data,0,6);
                $result=fee_tray($data);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"$result",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            case '60':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"لطفا نوع محصول مورد نظر را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"گرم",'callback_data'=>'62'],
                                ['text'=>"سرد و مشکی",'callback_data'=>'61']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'11']
                            ]
                        ]
                    ])
                ]);
            break;

            case '61': case '62':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"لطفا محصول مورد نظر را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"لوله",'callback_data'=>$data.'63']
                            ],
                            [
                                ['text'=>"بست اسپیت",'callback_data'=>$data.'65'],
                                ['text'=>"بوشن لوله",'callback_data'=>$data.'64']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'60']
                            ]
                        ]
                    ])
                ]);
            break;

            case '63': case '64': case '65':
                $back=substr($data,0,2);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"لطفا سایز مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"21",'callback_data'=>$data.'68'],
                                ['text'=>"16",'callback_data'=>$data.'67'],
                                ['text'=>"13",'callback_data'=>$data.'66']
                            ],
                            [
                                ['text'=>"48",'callback_data'=>$data.'71'],
                                ['text'=>"36",'callback_data'=>$data.'70'],
                                ['text'=>"29",'callback_data'=>$data.'69']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            case '66': case '67': case '68': case '69': case '70': case '71':
                $back=substr($data,0,4);
                $text=fee_steelpipe($data);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>$text,
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            case '80':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"لطفا محصول مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"گلند دو پیچ",'callback_data'=>'82'],
                                ['text'=>"لوله فلکسی",'callback_data'=>'81']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'11']
                            ]
                        ]
                    ])
                ]);
            break;

            case '81': case '82':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"لطفا سایز مورد نظر خود را انتخاب کنید",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"16",'callback_data'=>$data.'85'],
                                ['text'=>"13",'callback_data'=>$data.'84'],
                                ['text'=>"11",'callback_data'=>$data.'83']
                            ],
                            [
                                ['text'=>"36",'callback_data'=>$data.'88'],
                                ['text'=>"29",'callback_data'=>$data.'87'],
                                ['text'=>"21",'callback_data'=>$data.'86']
                            ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'80']
                            ]
                        ]
                    ])
                ]);
            break;

            case '83': case '84':case '85': case '86':case '87': case '88':
                $back=substr($data,0,2);
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"قیمت هر متر",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>$back]
                            ]
                        ]
                    ])
                ]);
            break;

            default:
                # code...
            break;
        }


        
}else
{
    makeHTTPRequest('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"برای ادامه لطفا آیتم مورد نظر خود را انتخاب کنید
        ",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"قیمت ها",'callback_data'=>'11']
                ],
                [
                    ['text'=>"ارتباط با ما",'callback_data'=>'13'],
                    ['text'=>"فعالیت های ما",'callback_data'=>'12']
                ]
            ]
        ])
    ]);

    // header('Content-Type: text/html; charset=utf-8');
    // $host="localhost";
    // $username="mghinfo_root";
    // $password="jJoiTnM3y";
    // $dbname = "mghinfo_blog";

    // $conn = new mysqli($host, $username, $password,$dbname);
    // mysqli_set_charset($conn,"utf8");

    // $fname=$update->message->from->first_name;
    // $lname=$update->message->from->last_name;
    // $username=$update->message->from->username;

    // date_default_timezone_set('Asia/Tehran');
    // $timestamp = date("Y-m-d");

    // $sql="insert into tusers (fname,lname,username,created_at) values ('{$fname}','{$lname}','{$username}',
    //                                                                      '{$timestamp}')";
    // $conn->query($sql);
    // $conn-close();


}

?>