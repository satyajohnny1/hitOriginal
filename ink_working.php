<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 
if (isset($_POST)) {
$rest_json = file_get_contents("php://input");
$msg = json_decode($rest_json, true);


$combined = array_map(
function($a, $b) 
{ 
return $a.' - '.$b; 
}, explode(",", $msg['stocks']), explode(",", $msg['trigger_prices']));
sort($combined);
$combined = implode("%0A", $combined);
$msg = rawurldecode("<b>{$msg['alert_name']}</b>".'%0A%0A'.$combined.'%0A%0A'."Triggered at {$msg['triggered_at']}.%0AChartink Alerts by @smlcodes%0A%0Ahttps://chartink.com/screener/{$msg["scan_url"]}");


}


if (isset($_GET['msg'])) {$msg = $_GET['msg'];}
 

$url = 'https://api.telegram.org/bot1837705010:AAH4xbAoI46QE1r5FYvnkIb2YbEmSfZBGrM/sendMessage';
$data = array('chat_id' => '976166333', 'parse_mode' => 'html', 'text' => $msg);

// use key 'http' even if you send the request to https://...
$options = array(
	"ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) { 
    //Handle error
    echo "ERROR. Message not sent.";
}

else {
    //var_dump($result);
    echo "Message sent.";
}

/*******


curl -H "Content-Type: application/json" --data @post.json http://localhost:8066/ink/a.php

https://github.com/php-telegram-bot/core









***/
?>