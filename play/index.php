<?php

include "../phpgram.php";

$token = '7337693933:AAGKjpcWREFw5u4U_efy0UkRbq692QxC87k';
$bot = new PhpGram($token);


$botInfo = $bot->getMe();
echo 'Bot Username: ' . $botInfo['result']['username'] . PHP_EOL;


