<?php

// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";

// การตั้งเกี่ยวกับ bot
require_once 'bot_settings.php';

//เชื่อมดาต้าเบส
//require_once 'rup_db.php'

$access_token = 'Dp5cTXj8NHTYDiKoy/fQeb1zcbXljHoONSe4hCHXj1SIQ2FJCCH7qQXjnvfjxR21PWBquHunHE0HZtRL8Ezq9xf7cxTdeI/fKSKy9uNqwBIn3XicVdrptnh7SW4nD77FZeYQgrBWfpTFW9FG1EEujQdB04t89/1O/w1cDnyilFU=';

$channelSecret = '1eb0fde205d854b1f21fedb2a645deee';

//$pushID = 'Ufd7798f8e80447988a4bf8a50dd9ac44';

///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;

// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
 
// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    $userMessage = strtolower($userMessage);
    switch ($typeMessage){
        case 'text':
            switch ($userMessage) {
                case "ดี":
                    $textReplyMessage = "สวัสดีครับผม Dr.P ยินดีรับใช้";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
                case "สติ๊กเกอร์":
                    $stickerID = 22;
                    $packageID = 2;
                    $replyData = new StickerMessageBuilder($packageID,$stickerID);
                    break;      
                case "กล่อง":
                    $replyData = new TemplateMessageBuilder('Confirm Template',
                        new ConfirmTemplateBuilder(
                                'TEST',
                                array(
                                    new MessageTemplateActionBuilder(
                                        'ใช่',
                                        'อืม.. ใช่ คงงั้นแหละ'
                                    ),
                                    new MessageTemplateActionBuilder(
                                        'ไม่',
                                        'ไม่อะ ไม่ใช่เลย'
                                    )
                                )
                        )
                    );
                    break;                   
                default:
                    $number = rand(1, 6);
                    if($number == 1){
                     $textReplyMessage = "ผมไม่เข้าใจครับ พูดใหม่ได้ไหมครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    else if($number == 2){
                     $textReplyMessage = "อะไรนะครับ พูดใหม่ได้ไหมครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    else if($number == 3){
                     $textReplyMessage = "ขอโทษครับ ลองพูดอีกครั้งได้ไหมครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    else if($number == 4){
                     $textReplyMessage = "ขอโทษครับ พูดอีกครั้งได้ไหมครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    else if($number == 5){
                     $textReplyMessage = "พูดอีกทีได้ไหมครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    else if($number == 6){
                     $textReplyMessage = "ว่ายังไงนะครับ";
                     $replyData = new TextMessageBuilder($textReplyMessage);
                    }
                    break;                                      
            }
            break;
        default:
            $textReplyMessage = json_encode($events);
            $replyData = new TextMessageBuilder($textReplyMessage);         
            break;  
    }
}
// ส่วนของคำสั่งจัดเตียมรูปแบบข้อความสำหรับส่ง
$textMessageBuilder = new TextMessageBuilder($textReplyMessage);
 
//l ส่วนของคำสั่งตอบกลับข้อความ
$response = $bot->replyMessage($replyToken,$replyData);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
 
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>







