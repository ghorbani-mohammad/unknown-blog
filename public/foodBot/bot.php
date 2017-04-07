<?php

include('db.php');
include('../jdf/jdf.php');


date_default_timezone_set('Asia/Tehran');
$now = new DateTime();
$timestamp = $now->getTimestamp();

$dw = date( "w", $timestamp);


$termStart=jalali_to_gregorian(1395,11,16);

$today = jdate('l j F');


$startDate = new DateTime("$termStart[0]-$termStart[1]-$termStart[2]");
$endDate = new DateTime($now->format('Y-m-d'));

$interval = $startDate->diff($endDate);

function numberToWord(int $number)
{
    switch ($number) 
    {
        case '1':
            return 'اول';
        break;
        case '2':
            return 'دوم';
        break;
        case '3':
            return 'سوم';
        break;
        case '4':
            return 'چهارم';
        break;
        case '5':
            return 'پنجم';
        break;
        case '6':
            return 'ششم';
        break;
        case '7':
            return 'هفتم';
        break;
        case '8':
            return 'هشتم';
        break;
        case '9':
            return 'نهم';
        break;
        case '10':
            return 'دهم';
        break;
        case '11':
            return 'یازدهم';
        break;
        case '12':
            return 'دوازدهم';
        break;
        case '13':
            return 'سیزدهم';
        break;
        case '14':
            return 'چهاردهم';
        break;
        case '15':
            return 'پانزدهم';
        break;
        case '16':
            return 'شانزدهم';
        break;
        case '17':
            return 'هفدهم';
        break;
        case '18':
            return 'هجدهم';
        break;
        default:
            return 'نامشخص';
        break;
    }
}

$educationalWeek=numberToWord((int)(($interval->days) / 7));


//


ini_set('error_reporting', E_ALL);
define('API_KEY','281762005:AAEkdKBSnDsCT46xWID4q-jy7p_uRvcKnYI');

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
        $chat_id = $update->callback_query->message->chat->id;
        $message_id = $update->callback_query->message->message_id;
        $callback_query_id=$update->callback_query->id;

        makeHTTPRequest('answerCallbackQuery',['callback_query_id'=>$callback_query_id]);



        $fname=$update->callback_query->from->first_name;
        $lname=$update->callback_query->from->last_name;
        $username=$update->callback_query->from->username;
        if($username!=ghorbani_mohammad)
        {
            makeHTTPRequest('sendMessage',[
            'chat_id'=>'110374168',
            'text'=>"#query:\n   Fname: ".$fname."\n   Lname: ".$lname."\n   Username: @".$username,
            ]);
        }    
        switch ($update->callback_query->data) 
        {

            case '0':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"امروز ".$today."-هفته ".$educationalWeek." آموزشی",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"🍔 غذای امروز 🍕",'callback_data'=>'1']
                            ],
                            [
                                ['text'=>"هفته بعد",'callback_data'=>'3'],
                                ['text'=>"هفته جاری",'callback_data'=>'2']
                            ],
                            [
                                ['text'=>"معرفی به دوستان",'switch_inline_query'=>'سلام، این ربات به نظرم مفید بود خواستم بهت معرفیش کنم']
                            ]
                        ]
                    ])
                ]);
            break;


            case '1':
                if($dw==6)
                {
                    $dw_1=0;
                    $dw_2=1;    
                }else{
                    $dw=$dw+1;
                    $dw=$dw*2;
                    $dw_1=$dw;
                    $dw_2=$dw+1;
                }
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"ناهار:".$foods_1[$dw_1]."\nشام:".$foods_1[$dw_2],
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>'0']
                            ]
                        ]
                    ])
                ]);
                break;


            case '2':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"🍔 هفته جاری 🍕",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"شنبه",'callback_data'=>'20']
                            ],
                            [
                                ['text'=>"یکشنبه",'callback_data'=>'21']
                            ],
                            [
                                ['text'=>"دوشنبه",'callback_data'=>'22']
                            ],
                            [
                                ['text'=>"سه شنبه",'callback_data'=>'23']
                            ],
                            [
                                ['text'=>"چهارشنبه",'callback_data'=>'24']
                            ],
                            [
                                ['text'=>"پنج شنبه",'callback_data'=>'25']
                            ],
                            // [
                            //     ['text'=>"جمعه",'callback_data'=>'26']
                            // ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'0']
                            ]

                        ]
                    ])
                ]);    
                break;


            case '20':case '21':case '22':case '23':case '24':case '25':case '26':
                $day=($update->callback_query->data)%20;
                $day_1=$day*2;
                $day_2=$day_1+1;
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"ناهار:".$foods_1[$day_1]."\nشام:".$foods_1[$day_2],
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>'2']
                            ]
                        ]
                    ])
                ]);
                break;

            case '3':
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"🍔 هفته بعد 🍕",
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"شنبه",'callback_data'=>'30']
                            ],
                            [
                                ['text'=>"یکشنبه",'callback_data'=>'31']
                            ],
                            [
                                ['text'=>"دوشنبه",'callback_data'=>'32']
                            ],
                            [
                                ['text'=>"سه شنبه",'callback_data'=>'33']
                            ],
                            [
                                ['text'=>"چهارشنبه",'callback_data'=>'34']
                            ],
                            [
                                ['text'=>"پنج شنبه",'callback_data'=>'35']
                            ],
                            // [
                            //     ['text'=>"جمعه",'callback_data'=>'36']
                            // ],
                            [
                                ['text'=>"بازگشت",'callback_data'=>'0']
                            ]

                        ]
                    ])
                ]);    
                break;

            case '30':case '31':case '32':case '33':case '34':case '35':case '36':
                $day=($update->callback_query->data)%30;
                $day_1=$day*2;
                $day_2=$day_1+1;
                makeHTTPRequest('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id,
                    'text'=>"ناهار:".$foods_2[$day_1]."\nشام:".$foods_2[$day_2],
                    'reply_markup'=>json_encode([
                        'inline_keyboard'=>[
                            [
                                ['text'=>"بازگشت",'callback_data'=>'3']
                            ]
                        ]
                    ])
                ]);
                break;

    }    
}else
{
    $fname=$update->message->from->first_name;
    $lname=$update->message->from->last_name;
    $username=$update->message->from->username;
    $text=$update->message->text;
    if($text=="/start")
    {
        $sql="insert into fusers (fname,lname,username) values ('{$fname}','{$lname}','{$username}')";
        $conn->query($sql);
        if($username!=ghorbani_mohammad)
        {
            makeHTTPRequest('sendMessage',[
                'chat_id'=>'110374168',
                'text'=>"#start:\n   Fname: ".$fname."\n   Lname: ".$lname."\n   Username: @".$username,
            ]); 
        }
    }

    makeHTTPRequest('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"امروز ".$today."-هفته ".$educationalWeek." آموزشی",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"🍔 غذای امروز 🍕",'callback_data'=>'1']
                ],
                [
                    ['text'=>"هفته بعد",'callback_data'=>'3'],
                    ['text'=>"هفته جاری",'callback_data'=>'2']
                ],
                [
                    ['text'=>"معرفی به دوستان",'switch_inline_query'=>'سلام، این ربات به نظرم مفید بود خواستم بهت معرفیش کنم']
                ]
            ]
        ])
    ]);
    
    
}

    $conn->close();

?>