<?php


require 'phpgram.php';


// Replace with your bot token
$botToken = '7337693933:AAGKjpcWREFw5u4U_efy0UkRbq692QxC87k';
$bot = new PhpGram($botToken);


// URL of the Telegram API for sending messages
$apiURL = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';

// Get the incoming message and chat ID
$update = json_decode(file_get_contents('php://input'), true);
$chatId = $update['message']['chat']['id'];
$messageId = $update['message']['message_id'];
$command = trim($update['message']['text']);
// Command to handle
if ($command == '/flipcoin') {
    // Generate random number (0 or 1)
    $random = mt_rand(0, 1);

    // Determine the result
    $result = ($random == 0) ? "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih" : "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fdfvyolmbeynvtnluncmq";

    // Send the result
    $bot->sendPhoto($chatId, $result);
} elseif ($command == '/rolladice') {

    // Generate random number (1 to 6)
    $random = mt_rand(1, 6);

    // // Determine the result
    // $result = "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih";

    // // Send the result
    // $bot->sendPhoto($chatId, $result);

    // Send the result
    $bot->sendMessage($chatId, 'The dice rolled: ' . $random);
} elseif ($command == '/start') {
    // Send a welcome message
    $bot->sendMessage($chatId, 'Welcome to the bot! You can use the following commands: /flipcoin, /rolladice');

    // Send a photo
    $bot->sendPhoto($chatId, 'https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih');

} else {

    // Send a message
    $bot->sendMessage($chatId, 'Invalid command! Please use one of the following commands: /flipcoin, /rolladice');
}
