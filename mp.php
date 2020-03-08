<?php

ob_start();

$API_KEY = '138219119:AAEPt-Xfl3LNqbAPbFc8-nkYxPkD2LN3LJY';
##------------------------------##
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
   function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $update->message->message_id;
$from_id = $message->from->id;
$username = $message->from->username;
$text = $message->text;

if(isset($update->callback_query)){
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $from_id = $update->callback_query->from->id;
    $username = $update->callback_query->from->username;

if($data=="Voice_Audio"){
            file_put_contents("data/$from_id/settings.txt","Voice_Audio");
                              file_put_contents("data/$from_id/performer.txt","");
              file_put_contents("data/$from_id/title.txt","");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Iltimos, ovozni endi yuboring 🔊",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_audio_title"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_audio_title");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, ismingizni hozir yuboring🖊",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_audio"]
                        ]
                ]
            ])
  ]);
}
if($data == "Change_audio_performer"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_audio_performer");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, qushiqchining ismini hozir yuboring🎻",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_audio"]
                        ]
                ]
            ])
  ]);
}
if($data == "Change_audio_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_audio_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_audio"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_audio_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_audio_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_audio_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_audio_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_audio_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_audio_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_audio_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_audio_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_audio_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_audio_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_audio_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_audio_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_audio_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_audio_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_audio_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_audio_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_audio_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_audio_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_audio_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_audio_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_audio_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_audio_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_audio_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_audio_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_audio"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_audio"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_audio"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}





//-------share audio --------------






if ($data == "send_audio_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_audio_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$idchannel,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
]);
}










//end








if($data=="Audio_voice"){
            file_put_contents("data/$from_id/settings.txt","Audio_voice");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Iltimos, endi ovozli xabarlarni yuboring🎼",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_voice_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_voice_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_voice"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_voice_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_voice_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_voice_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_voice_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_voice_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_voice_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_voice_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_voice_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_voice_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_voice_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_voice_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_voice_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_voice_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_voice_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_voice_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_voice_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_voice_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_voice_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_voice_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_voice_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_voice_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_voice_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_voice_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_voice_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_voice"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_voice"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_voice"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}


//====start share voice





if ($data == "send_voice_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_voice_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvoice',[
    'chat_id'=>$idchannel,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
]);
}



//end












if($data=="Photo_sticker"){
            file_put_contents("data/$from_id/settings.txt","Photo_sticker");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Iltimos, hozir rasmni yuboring📷",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_sticker_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_sticker_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_sticker"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_sticker_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_sticker_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_sticker_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_sticker_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_sticker_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_sticker_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_sticker_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_sticker_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_sticker_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_sticker_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_sticker_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_sticker_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_sticker_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_sticker_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_sticker_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_sticker_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_sticker_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_sticker_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_sticker_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_sticker_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_sticker_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_sticker_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_sticker_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_sticker_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_sticker"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_sticker"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_sticker"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}


//====start share sticker





if ($data == "send_sticker_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_sticker_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendsticker',[
    'chat_id'=>$idchannel,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
]);
}



//end










if($data=="Sticker_photo"){
            file_put_contents("data/$from_id/settings.txt","Sticker_photo");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Iltimos, afishani hozir yuboring🎆",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_photo_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_photo_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_photo"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_photo_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_photo_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_photo_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_photo_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_photo_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_photo_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_photo_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_photo_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_photo_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_photo_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_photo_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_photo_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_photo_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_photo_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_photo_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_photo_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_photo_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_photo_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_photo_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_photo_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_photo_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_photo_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_photo_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_photo_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_photo"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_photo"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_photo"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}


//====start share photo





if ($data == "send_photo_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_photo_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendphoto',[
    'chat_id'=>$idchannel,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
]);
}



//end









if($data=="Video_Gif"){
            file_put_contents("data/$from_id/settings.txt","Video_Gif");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Videoni endi yuboring🎞",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_gif_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_gif_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_gif"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_gif_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_gif_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_gif_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_gif_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_gif_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_gif_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_gif_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_gif_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_gif_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_gif_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_gif_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_gif_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_gif_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_gif_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_gif_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_gif_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_gif_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_gif_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_gif_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_gif_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_gif_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_gif_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_gif_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_gif_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_gif"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_gif"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_gif"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}


//====start share gif





if ($data == "send_gif_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_gif_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
]);
}



//end

if($data=="Photo_stickerp"){
            file_put_contents("data/$from_id/settings.txt","Photo_stickerp");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Iltimos, hozir rasmni yuboring📷",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list_formulas"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_stickerp_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_stickerp_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_stickerp"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_stickerp_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_stickerp_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_stickerp_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_stickerp_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_stickerp_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_stickerp_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_stickerp_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_stickerp_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_stickerp_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_stickerp_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_stickerp_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_stickerp_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_stickerp_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_stickerp_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_stickerp_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_stickerp_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_stickerp_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_stickerp_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_stickerp_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_stickerp_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_stickerp_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_stickerp_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_stickerp_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_stickerp_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_stickerp"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_stickerp"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_stickerp"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}










//====start share gif





if ($data == "send_stickerp_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_stickerp_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('senddocument',[
    'chat_id'=>$idchannel,
'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
]);
}



//end

if($data=="Download_YouTube"){
            file_put_contents("data/$from_id/settings.txt","link_youtube");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Menga hozir video havolasini yuboring🗳",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Home"],
                        ]
                ]
            ])
  ]);
}

if($data == "Change_youtube_caption"){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/settings.txt","Change_youtube_caption");
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, hozir matnni yuboring📋",
      'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_youtube"]
                        ]
                ]
            ])
  ]);
}
if($data == "Remove_youtube_caption"){
    bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
        file_put_contents("data/$from_id/caption.txt","");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
 bot('editMessageCaption',[
   'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'inline_message_id' => $update->callback_query->inline_message_id,
    'caption'=>"",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
  ]);
}
if($data == "Share_youtube_channel"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
    $explode = scandir("data/$from_id/channel");
   bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
                               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"$explode[2]",'callback_data'=>"send_youtube_channel1"],
['text'=>"$explode[3]",'callback_data'=>"send_youtube_channel2"],
                        ],
                    [
                        ['text'=>"$explode[4]",'callback_data'=>"send_youtube_channel3"],
['text'=>"$explode[5]",'callback_data'=>"send_youtube_channel4"],
                        ],
                    [
                        ['text'=>"$explode[6]",'callback_data'=>"send_youtube_channel5"],
['text'=>"$explode[7]",'callback_data'=>"send_youtube_channel6"],
                        ],
                    [
                        ['text'=>"$explode[8]",'callback_data'=>"send_youtube_channel7"],
['text'=>"$explode[9]",'callback_data'=>"send_youtube_channel8"],
                        ],
                    [
                        ['text'=>"$explode[10]",'callback_data'=>"send_youtube_channel9"],
['text'=>"$explode[11]",'callback_data'=>"send_youtube_channel10"],
                        ],
                    [
                        ['text'=>"$explode[12]",'callback_data'=>"send_youtube_channel11"],
['text'=>"$explode[13]",'callback_data'=>"send_youtube_channel12"],
                        ],
                    [
                        ['text'=>"$explode[14]",'callback_data'=>"send_youtube_channel13"],
['text'=>"$explode[15]",'callback_data'=>"send_youtube_channel14"],
                        ],
                    [
                        ['text'=>"$explode[16]",'callback_data'=>"send_youtube_channel15"],
['text'=>"$explode[17]",'callback_data'=>"send_youtube_channel16"],
                        ],
                    [
                        ['text'=>"$explode[18]",'callback_data'=>"send_youtube_channel17"],
['text'=>"$explode[19]",'callback_data'=>"send_youtube_channel18"],
                        ],
                    [
                        ['text'=>"$explode[20]",'callback_data'=>"send_youtube_channel19"],
['text'=>"$explode[21]",'callback_data'=>"send_youtube_channel20"],
                        ],
                    [
                        ['text'=>"$explode[22]",'callback_data'=>"send_youtube_channel21"],
['text'=>"$explode[23]",'callback_data'=>"send_youtube_channel22"],
                        ],
                        [
                            ['text'=>"Orqaga ↪️",'callback_data'=>"Back_youtube"],
                            ]
                ]
            ])
]);
}else {
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if($data == "Back_youtube"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
       bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}

if($data =="Cancel_youtube"){
            file_put_contents("data/$from_id/settings.txt","");
      bot('deleteMessage',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id
        ]);
}





//====start share gif





if ($data == "send_youtube_channel1"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[2]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel2"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[3]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel3"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[4]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel4"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[5]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel5"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[6]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel6"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[7]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel7"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[8]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel8"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[9]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel9"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[10]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}if ($data == "send_youtube_channel10"){
    $explode = scandir("data/$from_id/channel");
    $idchannel = file_get_contents("data/$from_id/channel/$explode[11]");
    $title = file_get_contents("data/$from_id/title.txt");
    $performer = file_get_contents("data/$from_id/performer.txt");
    $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendvideo',[
    'chat_id'=>$idchannel,
'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
  ]);
         bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Posted",
        'show_alert'=>true
    ]);
 bot('editMessageReplyMarkup',[
   'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'inline_message_id' => $update->callback_query->inline_message_id,
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
]);
}



//end















if($data=="Video_voice"){
            file_put_contents("data/$from_id/settings.txt","Video_voice");
            file_put_contents("data/$from_id/caption.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"Videoni endi yuboring🎞",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Converter_list"],
                        ]
                ]
            ])
  ]);
}






if($data == "add_channel"){
mkdir("data/$from_id/channel");
            file_put_contents("data/$from_id/settings.txt","add_channel");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"⚠️ Iltimos, kanaldagi administrator botni kutarib, keyin (id, qullar yoki qayta yunaltirishni yuboring))",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Chiqing🗑",'callback_data'=>"Cancel_audio"]
                        ]
                ]
            ])
	]);
}
if($data=="Home"){
                file_put_contents("data/$from_id/settings.txt","");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
	  'text'=>"🌐 Salom [@$username](t.me/$username) !
▪ Boot'a xush kelibsiz * MediaCovBot *
FileProtect fayl formatlarini uzgartiradi
▪ Fayllarni bir formatdan ikkinchisiga aylantirishingiz mumkin.
▪ Suratlar, ovozlar, plakatlar, videolar va bir nechta fayllarni yuklab oling!
Qushimcha ma'lumot uchun "About" -ga teging",
      'parse_mode'=>'MarkDown',
     'disable_web_page_preview'=>'true',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Ishlab chiqarish ruyxati",'callback_data'=>"Converter_list"],['text'=>"Formulalar ruyxatini konvertatsiya qilish",'callback_data'=>"Converter_list_formulas"],
                        ],
                                                       [
                            ['text'=>"Youtube-dan yuklab olish",'callback_data'=>"Download_YouTube"],
                                ],
                            [
                        ['text'=>"Mening kanallarim",'callback_data'=>"Your_Channels"],['text'=>"Haqida",'callback_data'=>"About"],
                                ]
                ]
            ])
	]);
}
if($data=="About"){
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
	  'text'=>" 🔘 _pot _

▫ - video va audio urtasida aylanadigan bot

Ta'rifni uzgartirishingiz mumkin
Kanallarni qushing va tuuridan-tuuri kanalingizga uzgartirmoqchi bulgan narsani yuboring.

Idishning tagida bir jamoa bor edi👥 [TeamEvs](t.me/teamevs)",
'disable_web_page_preview'=>'true',
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Orqaga ↪️",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
if($data == "Your_Channels"){
$ok = file_get_contents("data/$from_id/ok_channel.txt");
if($ok){
        bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"Iltimos, kuting⏱",
    ]);
$list = scandir("data/$from_id/channel");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){
        continue;
        }else{
$user = file_get_contents("data/$from_id/list.txt");
    $members = explode("\n",$user);
    if (!in_array($list[$i]."\n ___________",$members)){
      $add_user = file_get_contents("data/$from_id/list.txt");
      $add_user .= $list[$i]."\n ___________"."\n";
     file_put_contents("data/$from_id/list.txt",$add_user);
    }
}
}
file_put_contents("data/$from_id/ok_channel.txt","ok");
  $listaaaa = file_get_contents("data/$from_id/list.txt");
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"Sizning kanallaringiz↙️\n $listaaaa",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanalni tozalash",'callback_data'=>"delete_channel"],['text'=>"Kanal qushish",'callback_data'=>"add_channel"]
                        ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
        file_put_contents("data/$from_id/list.txt", "");
}else {
	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
	  'text'=>"The Siz kanallar ruyxatida hech qanday kanal yuq
Your Fayllarni bulishish uchun kanallarni qushishingiz kerak",
      'parse_mode'=>'MarkDown',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanallarni qushing",'callback_data'=>"add_channel"],['text'=>"Asosiy menyu",'callback_data'=>"Home"],
                        ]
                ]
            ])
	]);
}
}
if ($data == "Converter_list"){
     file_put_contents("data/$from_id/settings.txt","");
    	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"---------------------------
¯\_(ツ)_/¯
---------------------------",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                                               ['text'=>"Ovoz> Ovozli xabarlar-ni tanlang",'callback_data'=>"Voice_Audio"],['text'=>"Ovozli xabarlar> Ovoz",'callback_data'=>"Audio_voice"],
                        ],
                [
                      ['text'=>"Video> Ovoz",'callback_data'=>"Video_voice"],['text'=>"Video> harakatlanuvchi Giflar",'callback_data'=>"Video_Gif"]
                    ],
                    [
                        ['text'=>"Surat> Devoriy gazetalar",'callback_data'=>"Photo_sticker"], ['text'=>"Devoriy> Rasm",'callback_data'=>"Sticker_photo"]
                        ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
}
if ($data == "Converter_list_formulas"){
        file_put_contents("data/$from_id/settings.txt","");
    	bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"---------------------------
¯\_(ツ)_/¯
---------------------------",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Surat> Devoriy gazetalar (PNG)",'callback_data'=>"Photo_stickerp"]
                        ],
                        [
                                                    ['text'=>"قريبآ 💡",'callback_data'=>"##"]
                            ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
}
if($data == "Subscriptions_publishing"){
            bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"قريبآ 💡",
    ]);
}
//------------------------------------------
}
if(preg_match("/^\/([Ss][Tt][Aa][Rr][Tt])/s",$text)){
    mkdir("data/$from_id");
         file_put_contents("data/$from_id/settings.txt","");
    bot('SendMessage',[
	  'chat_id'=>$chat_id,
	  'text'=>"🌐 Salom [@$username](t.me/$username) !
▪ Boot'a xush kelibsiz * MediaCovBot *
FileProtect fayl formatlarini uzgartiradi
▪ Fayllarni bir formatdan ikkinchisiga aylantirishingiz mumkin.
▪ Suratlar, ovozlar, plakatlar, videolar va bir nechta fayllarni yuklab oling!
Qushimcha ma'lumot uchun "About" -ga teging",
      'parse_mode'=>'MarkDown',
'disable_web_page_preview'=>'true',
               'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Ishlab chiqarish ruyxati",'callback_data'=>"Converter_list"],['text'=>"Formulalar ruyxatini konvertatsiya qilish",'callback_data'=>"Converter_list_formulas"],
                        ],
                            [
                            ['text'=>"Youtube-dan yuklab olish",'callback_data'=>"Download_YouTube"],
                                ],
                            [
                        ['text'=>"Mening kanallarim",'callback_data'=>"Your_Channels"],['text'=>"Haqida",'callback_data'=>"About"],
                                ]
                ]
            ])
	]);
}
//-------------------------
//------------ audio ---------------
$settings = file_get_contents("data/$from_id/settings.txt");
$voice = $message->voice;
if($settings=="Voice_Audio" and $voice and $from_id != "310654951"){
    $size = $update->message->voice->file_size;
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $voice->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('sendAudio',[
    'chat_id'=>$chat_id,
    'audio'=>new CURLFile("$username"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"]
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_audio_title" and $text and $from_id != "310654951"){
    	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
          file_put_contents("data/$from_id/title.txt","$text");
          $performer = file_get_contents("data/$from_id/performer.txt");
          $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$chat_id,
    'audio'=>new CURLFile("$username"),
    'title'=>"$text",
    'performer'=>"$performer",
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                            ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_audio_performer" and $text and $from_id != "310654951"){
    	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/performer.txt","$text");
              $title = file_get_contents("data/$from_id/title.txt");
              $caption = file_get_contents("data/$from_id/caption.txt");
      bot('sendAudio',[
    'chat_id'=>$chat_id,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$text",
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                            ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_audio_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
              $title = file_get_contents("data/$from_id/title.txt");
          $performer = file_get_contents("data/$from_id/performer.txt");
      bot('sendAudio',[
    'chat_id'=>$chat_id,
    'audio'=>new CURLFile("$username"),
    'title'=>"$title",
    'performer'=>"$performer",
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                    [
                        ['text'=>"Ismni uzgartirish",'callback_data'=>"Change_audio_title"],['text'=>"Qushiqchining nomi uzgargan",'callback_data'=>"Change_audio_performer"],
                        ],
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_audio_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_audio_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_audio_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}


// voice

$settings = file_get_contents("data/$from_id/settings.txt");
$audio = $message->audio;
if($settings=="Audio_voice" and $audio and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $audio->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('sendvoice',[
    'chat_id'=>$chat_id,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_voice_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('sendvoice',[
    'chat_id'=>$chat_id,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}




$settings = file_get_contents("data/$from_id/settings.txt");
$photo = $message->photo;
if($settings=="Photo_sticker" and $photo and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $update->message->photo[1]->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('sendsticker',[
    'chat_id'=>$chat_id,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_sticker_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('sendsticker',[
    'chat_id'=>$chat_id,
    'sticker'=>new CURLFile("$username"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_sticker_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_sticker_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_sticker_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}






$settings = file_get_contents("data/$from_id/settings.txt");
$sticker = $message->sticker;
if($settings=="Sticker_photo" and $sticker and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $update->message->sticker->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('sendphoto',[
    'chat_id'=>$chat_id,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_photo_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('sendphoto',[
    'chat_id'=>$chat_id,
    'photo'=>new CURLFile("$username"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_photo_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_photo_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_photo_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}

$settings = file_get_contents("data/$from_id/settings.txt");
$video = $message->video;
if($settings=="Video_Gif" and $video and $from_id != "310654951"){
    $size = $update->message->video->file_size;
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $video->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username.gif",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$username.gif"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_gif_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$username.gif"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_gif_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_gif_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_gif_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}

$settings = file_get_contents("data/$from_id/settings.txt");
$photo = $message->photo;
if($settings=="Photo_stickerp" and $photo and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $update->message->photo[1]->file_id;

$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
 file_put_contents("$username.png",file_get_contents('http://qitmirvoy.zadc.ru/klientlar/abror2/demo/image/fetch/w_512,h_512,f_auto/https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$username.png"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_stickerp_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$username.png"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_stickerp_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_stickerp_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_stickerp_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}
$settings = file_get_contents("data/$from_id/settings.txt");
$text = $message->text;
if($settings=="link_youtube" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
    $get = json_decode(file_get_contents("https://api.unblockvideos.com/youtube_downloader?id=".$text."&selector=mp4"));
    $array = objectToArrays($get);
    $url = $array["0"]["url"];
    $url2 = file_get_contents($url);
    file_put_contents("$username.mp4",$url2);
    bot('sendvideo',[
    'chat_id'=>$chat_id,
    'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="Change_youtube_caption" and $text and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Iltimos, kuting⏱",
      'parse_mode'=>'MarkDown',
  ]);
              file_put_contents("data/$from_id/caption.txt","$text");
      bot('sendvideo',[
    'chat_id'=>$chat_id,
    'video'=>new CURLFile("$username.mp4"),
    'caption'=>"$text",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_youtube_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_youtube_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_youtube_channel"]
                            ]
                ]
            ])
  ]);
      file_put_contents("data/$from_id/settings.txt","");
}
if($settings=="add_channel" and $text and $from_id != "310654951"){
//----------------------
if ($text){
    $fu = json_decode(file_get_contents("api.telegram.org/bot$API_KEY/getChat?chat_id=$text"))->result->username;
if (file_exists("data/$from_id/channel/@$fu")){
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Bu kanal (@$fu) botga qushilgan☑️"
            ]);
                    continue;
}

$stat = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=@$fu&user_id=115056828");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$statq = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=@$fu&user_id=$from_id");
$statjsonq = json_decode($statq, true);
$statuss = $statjsonq['result']['status'];
if($getChatRes['result']['type'] === 'channel'){
if($status == "administrator"){
if($statuss == "administrator" or $statuss == "creator"){
$id = $getChatRes['result']['id'];
file_put_contents("data/$from_id/channel/@$fu","$id");
file_put_contents("data/$from_id/settings.txt","");
//---------------
$list = scandir("data/$from_id/channel");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){
        continue;
        }else{
$user = file_get_contents("data/$from_id/list.txt");
    $members = explode("\n",$user);
    if (!in_array($list[$i]."\n _______",$members)){
      $add_user = file_get_contents("data/$from_id/list.txt");
      $add_user .= $list[$i]."\n _______"."\n";
     file_put_contents("data/$from_id/list.txt",$add_user);
    }
}
}
file_put_contents("data/$from_id/ok_channel.txt","ok");
  $listaaaa = file_get_contents("data/$from_id/list.txt");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"Sizning kanallaringiz↙️\n $listaaaa",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanalni tozalash",'callback_data'=>"delete_channel"],['text'=>"Kanal qushish",'callback_data'=>"add_channel"]
                        ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
        file_put_contents("data/$from_id/list.txt", "");
//----------------
}else{
      bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda ma'mur bulmasligingiz uchun chiziq bor🚫",
      'parse_mode'=>'MarkDown',
  ]);
}
}else{
      bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda botni kutarish kerak bulgan chiziq bor⚠️",
      'parse_mode'=>'MarkDown',
  ]);
}
}
}
//--------------
if($update->message->forward_from_chat != null){
   $f = $message->forward_from_chat;
   $fu = $f->username;
if (file_exists("data/$from_id/channel/@$fu")){
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Bu kanal (@$fu) botga qushilgan☑️"
            ]);
                    continue;
}

$stat = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=@$fu&user_id=310654951");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$statq = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=@$fu&user_id=$from_id");
$statjsonq = json_decode($statq, true);
$statuss = $statjsonq['result']['status'];
if($getChatRes['result']['type'] === 'channel'){
if($status == "administrator"){
if($statuss == "administrator" or $statuss == "creator"){
$id = $getChatRes['result']['id'];
file_put_contents("data/$from_id/channel/@$fu","$id");
file_put_contents("data/$from_id/settings.txt","");
//---------------
$list = scandir("data/$from_id/channel");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){
        continue;
        }else{
$user = file_get_contents("data/$from_id/list.txt");
    $members = explode("\n",$user);
    if (!in_array($list[$i]."\n _______",$members)){
      $add_user = file_get_contents("data/$from_id/list.txt");
      $add_user .= $list[$i]."\n _______"."\n";
     file_put_contents("data/$from_id/list.txt",$add_user);
    }
}
}
file_put_contents("data/$from_id/ok_channel.txt","ok");
  $listaaaa = file_get_contents("data/$from_id/list.txt");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"Sizning kanallaringiz↙️\n $listaaaa",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanalni tozalash",'callback_data'=>"delete_channel"],['text'=>"Kanal qushish",'callback_data'=>"add_channel"]
                        ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
        file_put_contents("data/$from_id/list.txt", "");
//----------------
}else{
      bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda ma'mur bulmasligingiz uchun chiziq bor🚫",
      'parse_mode'=>'MarkDown',
  ]);
}
}else{
      bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda botni kutarish kerak bulgan chiziq bor⚠️",
      'parse_mode'=>'MarkDown',
  ]);
}
}
}
//------------------------
if(preg_match('/^(@)(.*)/',$text)){
if (file_exists("data/$from_id/channel/$text")){
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"هذة القناة ($text) حقآ تم اضافتها للبوت ☑️"
            ]);
                    continue;
}
$getChatReq = file_get_contents("https://api.telegram.org/bot$API_KEY/getChat?chat_id=".urlencode($text));
$getChatRes = json_decode($getChatReq, true);
$stat = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$text&user_id=310654951");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$statq = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$text&user_id=$from_id");
$statjsonq = json_decode($statq, true);
$statuss = $statjsonq['result']['status'];
if($getChatRes['result']['type'] === 'channel'){
if($status == "administrator"){
if($statuss == "administrator" or $statuss == "creator"){
$id = $getChatRes['result']['id'];
file_put_contents("data/$from_id/channel/$text","$id");
file_put_contents("data/$from_id/settings.txt","");
//---------------
$list = scandir("data/$from_id/channel");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){
        continue;
        }else{
$user = file_get_contents("data/$from_id/list.txt");
    $members = explode("\n",$user);
    if (!in_array($list[$i]."\n ___________",$members)){
      $add_user = file_get_contents("data/$from_id/list.txt");
      $add_user .= $list[$i]."\n ___________"."\n";
     file_put_contents("data/$from_id/list.txt",$add_user);
    }
}
}
file_put_contents("data/$from_id/ok_channel.txt","ok");
  $listaaaa = file_get_contents("data/$from_id/list.txt");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"Sizning kanallaringiz↙️\n $listaaaa",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Kanalni tozalash",'callback_data'=>"delete_channel"],['text'=>"Kanal qushish",'callback_data'=>"add_channel"]
                        ],
                        [
                            ['text'=>"Asosiy menyu",'callback_data'=>"Home"]
                            ]
                ]
            ])
        ]);
        file_put_contents("data/$from_id/list.txt", "");
//----------------
}else{
    	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda ma'mur bulmasligingiz uchun chiziq bor🚫",
      'parse_mode'=>'MarkDown',
  ]);
}
}else{
    	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Kanalda botni kutarish kerak bulgan chiziq bor⚠️",
      'parse_mode'=>'MarkDown',
  ]);
}
}
}
//-----------------------
}

$video = $message->video;
if($settings=="Video_voice" and $video and $from_id != "310654951"){
	bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏱⏱⏱⏱",
      'parse_mode'=>'MarkDown',
  ]);
$file = $video->file_id;
$caption = $update->message->caption;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$username",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
    bot('sendvoice',[
    'chat_id'=>$chat_id,
    'voice'=>new CURLFile("$username"),
    'caption'=>"$caption",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
                        [
                        ['text'=>"Matn qushish",'callback_data'=>"Change_voice_caption"],['text'=>"Matnni tozalang",'callback_data'=>"Remove_voice_caption"]
                        ],
                        [
                              ['text'=>"Kanalimga ulashing",'callback_data'=>"Share_voice_channel"]
                            ]
                ]
            ])
  ]);
     file_put_contents("data/$from_id/settings.txt","");
}
?>