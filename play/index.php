<?php

// Replace with your bot token
$botToken = '7337693933:AAGKjpcWREFw5u4U_efy0UkRbq692QxC87k';


// Include the PhpGram library

include '../phpgram.php';


$bot = new PhpGram($botToken);


// URL of the Telegram API for sending messages
$apiURL = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';

// Get the incoming message and chat ID
$update = json_decode(file_get_contents('php://input'), true);
$chatId = $update['message']['chat']['id'];
$messageId = $update['message']['message_id'];
$command = trim($update['message']['text']);

$bot->sendMessage($chatId, 'Hello World!');
// Command to handle
if ($command == '/flipcoin') {
    // Generate random number (0 or 1)
    $random = mt_rand(0, 1);

    // Determine the result
    $result = ($random == 0) ? 'Heads' : 'Tails';

    // Send the result back to the user
    $data = [
        'chat_id' => $chatId,
        'text' => 'Result: ' . $result,
        'reply_to_message_id' => $messageId,
    ];

    // Use cURL to send the message
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
} else {
    // If the command is not recognized, do nothing (optional)
}
