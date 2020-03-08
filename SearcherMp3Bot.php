<?php

// @PHP_OWN kanali uchun maxsus



ob_start();
define('API_KEY','1145285593:AAHi2uS8fO6ORt9e3D3dmdqdRXTIs-uCttQ');
echo "https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME'];
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$from_id = $message->from->id;
$name = $update->message->from->first_name;
$ssa = json_decode(file_get_contents('yuklandi.json'),1);
    $status = bot('getChatMember',['chat_id'=>'@PHP_OWN','user_id'=>$from_id])->result->status;
        if($status == 'left'){
            bot('sendMessage',[
                'chat_id'=>$chat_id,
                'text'=>"Kanalga a`zo bo`ling  🚫' @PHP_OWN",
                'reply_to_message_id'=>$message->message_id,
            ]);
      exit();
        }
if($text != null){
    if($text == '/start'){
        bot('sendMessage',[
                'chat_id'=>$chat_id,
                'parse_mode'=>'markdown',
                'text'=>'*🔥”YouTube”dan video yuklab oluvchi
🤖”BOT”imizga hush kelibsiz 
🎵 Istalgan Musiqa Nomini Yozing,
✄1�7 Bot Sizga Mp3 Formatida yuboradi!
👨‍✈Tizim Havfsizligiga*  [@Abroriy] *Javobgar
♻️Guruh:* [@PHP_Masters]',
                'reply_markup'=>json_encode([
              'inline_keyboard'=>[
                  [['text'=>"Kanal azo buling", 'url'=>"https://t.me/PHP_OWN"]],
              ]
          ])
        ]);
    } elseif($text != (null and '/start')){
        if(preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $text)){
             preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $text, $match);
         $id = $match[1];
          bot('sendphoto',[
                  'chat_id'=>$chat_id,
                'photo'=>$text,
                'caption'=>"📌┇Kerakli bulimni tanlang",
            'reply_markup'=>json_encode([
                   'inline_keyboard'=>[
               [['text'=>'🎤┇Mp3','callback_data'=>"dl##$id"], ['text'=>'🎼┇Golos','callback_data'=>"vo##$id"] ],[['text'=>'🎬┇Video','callback_data'=>"vi##$id"] ]
               ]
               ])]);
        } else {
            $item = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".urlencode($text)."&type=video&key=AIzaSyBdKFK59eajOVchi0TpuKkNGbYx4ZpiduI&maxResults=10"))->items;
          $keyboard["inline_keyboard"]=[];
          for ($i=0; $i < count($item); $i++) { 
              $keyboard["inline_keyboard"][$i] = [['text'=>$item[$i]->snippet->title,'callback_data'=>'dl##'.$item[$i]->id->videoId]];
          }
          $reply_markup=json_encode($keyboard);
          bot('sendMessage',[
              'chat_id'=>$chat_id,
              'text'=>'🔍 Qidiruv natijalari:',
              'reply_markup'=>$reply_markup
          ]);
        }
    }
}
//ushbu kod @Abroriy tomonidan @PHP_OWN kanali orqali tarqatildi
if($data != null){
    $yt = explode('##', $data);
        if($yt[0] == 'vi'){
        $get = json_decode(file_get_contents("https://wapis.ga/yt/?url=https://www.youtube.com/watch?v=".$yt[1]));
        $info = $get->result;
        $title = $info->info->title;
        $url = $get; 
      bot('sendMessage',[
      'chat_id'=>$chat_id2,
      'text'=>'⬇️ Yuklanmoqda...',
     ]);
     
     
     $size = $url->result->video[2]->sizebits;
     if($size > 50000000){
         bot('sendMessage',[
             'chat_id'=>$chat_id2,
             'text'=>'🚫 Kotta hajmdagi videolar yuklanmaydi',
             ]);
     
     //} else {
         file_put_contents($chat_id2.'.mp4',file_get_contents( $url->result->video[2]->url ));
         $video = bot('sendvideo',[
           'chat_id'=>$chat_id2,
           'video'=>new CURLFile($chat_id2.'.mp4'),
           'reply_markup'=>json_encode([
                   'inline_keyboard'=>[
                            [['text'=>'🎼 Mp3 format','callback_data'=>'dl##'.$yt[1]], ['text'=>'🎤Golos format','callback_data'=>'vo##'.$yt[1]]],
                       [['text'=>'Ulashish💬\'','switch_inline_query'=>'video#'.$yt[1]]],        
           ]
    ])    
                 ]);
                 $ssa['video']['video#'.$yt[1]] = ['title'=>$info->info->title,'file_id'=>$video->result->video->file_id];
                 file_put_contents('yuklandi.json', json_encode($ssa));
     } 
      unlink($chat_id2.'.mp4');
    }
    if($yt[0] == 'vo'){
        $get = json_decode(file_get_contents("https://wapis.ga/yt/?url=https://www.youtube.com/watch?v=".$yt[1]));
        $info = $get->result;
        $title = $info->info->title;
        $url = $get; 
      bot('sendMessage',[
      'chat_id'=>$chat_id2,
      'text'=>'⬇️ Yuklanmoqda...',
     ]);
     
     $size = $url->result->video[2]->sizebits;
     if($size > 50000000){
         bot('sendMessage',[
             'chat_id'=>$chat_id2,
             'text'=>'🚫 Kotta hajmdagi goloslar yuklanmaydi',
             ]);
     
     } else {
     file_put_contents($chat_id2.'.ogg',file_get_contents( $url->result->video[2]->url ));
     $voice = bot('sendvoice',[
       'chat_id'=>$chat_id2,
       'voice'=>new CURLFile($chat_id2.'.ogg'),
       'reply_markup'=>json_encode([
               'inline_keyboard'=>[
                        [['text'=>'🎼 Mp3 format','callback_data'=>'dl##'.$yt[1]], ['text'=>'🎬Video format','callback_data'=>'video##'.$yt[1]]],
                       [['text'=>'Ulashish💬\'','switch_inline_query'=>'voice#'.$yt[1]]],        
           ]
    ])
           
             ]);
             $ssa['voice']['voice#'.$yt[1]] = ['title'=>$info->info->title,'file_id'=>$voice->result->voice->file_id];
             file_put_contents('yuklandi.json', json_encode($ssa));
     }
      unlink($chat_id2.'.ogg');
    }
    if($yt[0] == 'dl'){
        $get = json_decode(file_get_contents("https://wapis.ga/yt/?url=https://www.youtube.com/watch?v=".$yt[1]));
        $info = $get->result;
        $title = $info->info->title;
        $url = $get; 
      bot('sendMessage',[
      'chat_id'=>$chat_id2,
      'text'=>'⬇️ Yuklanmoqda...',
     ]);
     $du = explode(':', $url->result->info->duration);
     $duration = ((int)$du[0] * 60) + (int)$du[1]; 
     
     $size = $url->result->video[2]->sizebits;
     if($size > 50000000){
         bot('sendMessage',[
             'chat_id'=>$chat_id2,
             'text'=>'🚫 Kotta hajmdagi mp3lar yuklanmaydi',
             ]);
     
     } else {
         file_put_contents($chat_id2.'.mp3',file_get_contents( $url->result->video[2]->url ));
     $audio = bot('sendaudio',[
       'chat_id'=>$chat_id2,
       'audio'=>new CURLFile($chat_id2.'.mp3'),
       'performer'=>$url->result->info->author,
       'title'=>$url->result->info->title,
       'duration'=> $duration ,
       'reply_markup'=>json_encode([
               'inline_keyboard'=>[
                    [['text'=>'🎬 Video format','callback_data'=>'video##'.$yt[1]], ['text'=>'🎤Golos format','callback_data'=>'vo##'.$yt[1]]],
                       [['text'=>'Ulashish💬\'','switch_inline_query'=>'video#'.$yt[1]]],        
           ]
    ])
   
             ]);
             $ssa['audio']['audio#'.$yt[1]] = ['file_id'=>$audio->result->audio->file_id];
             file_put_contents('yuklandi.json', json_encode($ssa));
     }
      unlink($chat_id2.'.mp3');
    }

}
//ushbu kod @Abroriy tomonidan @PHP_OWN kanali orqali tarqatildi
if($update->inline_query != null){
    $yt = explode('#', $update->inline_query->query);
    if($yt[0] == 'audio' and $ssa['audio'][$update->inline_query->query] != null){
        bot('answerInlineQuery',[
            'inline_query_id'=>$update->inline_query->id,    
            'results' =>json_encode([[
                  'type'=>'audio',
                  'audio_file_id'=>$ssa['audio'][$update->inline_query->query]['file_id'],
                'id'=>base64_encode(rand(5,555)),
                ]])
     ]);
    } elseif($yt[0] == 'video' and $ssa['video'][$update->inline_query->query] != null){
        bot('answerInlineQuery',[
            'inline_query_id'=>$update->inline_query->id,    
            'results' =>json_encode([[
                  'type'=>'video',
                  'title'=>$ssa['video'][$update->inline_query->query]['title'],
                  'caption'=>$ssa['video'][$update->inline_query->query]['title'],
                  'video_file_id'=>$ssa['video'][$update->inline_query->query]['file_id'],
                'id'=>base64_encode(rand(5,555)),
                ]])
     ]);
    } elseif($yt[0] == 'voice' and $ssa['voice'][$update->inline_query->query] != null){
        bot('answerInlineQuery',[
            'inline_query_id'=>$update->inline_query->id,    
            'results' =>json_encode([[
                  'type'=>'voice',
                  'title'=>$ssa['voice'][$update->inline_query->query]['title'],
                  'caption'=>$ssa['voice'][$update->inline_query->query]['title'],
                  'voice_file_id'=>$ssa['voice'][$update->inline_query->query]['file_id'],
                'id'=>base64_encode(rand(5,555)),
                ]])
     ]);
    } else {
        $item = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".urlencode($update->inline_query->query)."&type=video&key=AIzaSyBdKFK59eajOVchi0TpuKkNGbYx4ZpiduI&maxResults=10"))->items;
           for($i=0;$i < count($item);$i++){
        $res[$i] = [
                'type'=>'article',
                'id'=>base64_encode(rand(5,555)),
                'thumb_url'=>$item[$i]->snippet->thumbnails->default->url,
                'title'=>$item[$i]->snippet->title,
                'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"https://www.youtube.com/watch?v=".$item[$i]->id->videoId],
          ];
    }
          $r = json_encode($res);
    bot('answerInlineQuery',[
            'inline_query_id'=>$update->inline_query->id,    
            'results' =>($r)
        ]);
    }
}