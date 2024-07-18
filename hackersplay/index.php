<?php


require __DIR__ . '/../phpgram.php';
require __DIR__ . '/dns.php';

use PhpGram\PhpGram;

// Replace with your bot token
$botToken = '7227210007:AAGYF1Rvk4cJZNtshC-2TYbn6I7TiAstb-c'; // Make sure to replace this with your actual bot token
$bot = new PhpGram($botToken);
$botlogger = "-1002182782769";

// URL of the Telegram API for sending messages is not needed to be stored as a variable since it's not used elsewhere

// Get the incoming message and chat ID
$update = json_decode(file_get_contents('php://input'), true);
$chatId = $update['message']['chat']['id'];
// $messageId is not used in this script, so it can be removed to clean up the code
$command = trim($update['message']['text']);

// Command to handle
if ($command == '/flipcoin') {
    // Generate random number (0 or 1)
    $random = mt_rand(0, 1);

    // Determine the result
    $result = ($random == 0) ? "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih" : "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fdfvyolmbeynvtnluncmq";
    // Send the result
    $bot->sendPhoto($chatId, $result, 'The coin flipped! /flipcoin again? 🪙 or /rolladice 🎲 ');
    $bot->sendPhoto($botlogger, $result, 'The coin flipped! /flipcoin again? 🪙 or /rolladice 🎲 ');

} elseif ($command == '/rolladice') {
    // Generate random number (1 to 6)
    $random = mt_rand(1, 6);

    // Determine the result
    $result = "https://cdn.statically.io/og/" . $random . ".png"; // Fixed concatenation issue

    // Send the result
    $bot->sendPhoto($chatId, $result, 'The dice rolled: ' . $random . ' 🎲 /rolladice again? or /flipcoin 🪙');
    $bot->sendPhoto($botlogger, $result, 'The dice rolled: ' . $random . ' 🎲 /rolladice again? or /flipcoin 🪙');

} elseif ($command == '/start') {
    // Send a welcome message
    $bot->sendMessage($chatId, 'Welcome to the bot! ✨ You can use the following commands: /flipcoin, /rolladice');
    $bot->sendMessage($botlogger, 'Welcome to the bot! ✨ You can use the following commands: /flipcoin, /rolladice - ' . $chatId);
    // The following lines are not needed for the /start command and can cause confusion
    // $result = ($random == 0) ? "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih" : "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fdfvyolmbeynvtnluncmq";
    // $bot->sendPhoto($chatId, $result, 'A coin flip! 🪙');

} 

elseif(strpos($command, '/dns') === 0) {
    $url = substr($command, 5);
    $url = 'https://bgp.he.net/dns/'.$url;
    $html = fetch_html_content($url);
    $innerHtml = extract_inner_html_by_id($html, 'dns' );

    $bot->sendMessage($chatId, " <b> New </b> ", ['parse_mode' => 'HTML']);
    $bot->sendMessage($chatId, $innerHtml, ['parse_mode' => 'HTML']);
    $bot->sendMessage($chatId, " <b> New2 </b> ");
    // $bot->sendMessage($chatId, sanitize_html_for_telegram($innerHtml), ['parse_mode' => 'HTML']);





}






else {
    // Send a message for invalid commands
    $bot->sendMessage($chatId, 'Invalid command! Please use one of the following commands: /flipcoin, /rolladice');
}
