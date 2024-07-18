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
if  ($command == '/start') {
    // Send a welcome message
    $bot->sendMessage($chatId, "Welcome to the DNS Lookup Bot! You can use the following commands:\n
    /dns [domain] - Get DNS information for a domain\n
    /ipinfo [IP address] - Get information about an IP address\n
    /whois [domain/IP address] - Get WHOIS information for a domain or IP address"
);

    // The following lines are not needed for the /start command and can cause confusion
    // $result = ($random == 0) ? "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fj22gcmxu7la47n3rbnb4ih" : "https://imagecdn.app/v1/images/https%3A%2F%2Fpics.shade.cool%2Fapi%2Fimages%2Fdfvyolmbeynvtnluncmq";
    // $bot->sendPhoto($chatId, $result, 'A coin flip! 🪙');

} 

elseif(strpos($command, '/dns') === 0) {
    $url = substr($command, 5);
    $url = 'https://bgp.he.net/dns/'.$url;
    $html = fetch_html_content($url);
    $innerHtml = extract_inner_html_by_id($html, 'dns' );
    $innerHtml = $bot->sanitize_html_for_telegram($innerHtml);

    $doubleQuotedText = str_replace('`', '"', $innerHtml);

// Convert \n to actual new lines
$finalText = str_replace('\n', "\n", $doubleQuotedText);

    $bot->sendMessage($chatId,$finalText , ['parse_mode' => 'HTML']);
}

elseif(strpos($command, '/ipinfo') === 0) {
    $url = substr($command, 8);
    $url = 'https://bgp.he.net/dns/'.$url;
    $html = fetch_html_content($url);
    $innerHtml = extract_inner_html_by_id($html, 'ipinfo' );
    $bot->sendMessage($chatId, $bot->sanitize_html_for_telegram($innerHtml), ['parse_mode' => 'HTML']);
}

elseif(strpos($command, '/whois') === 0) {
    $url = substr($command, 7);
    $url = 'https://bgp.he.net/dns/'.$url;
    $html = fetch_html_content($url);
    $innerHtml = extract_inner_html_by_id($html, 'whois' );
    $bot->sendMessage($chatId, $bot->sanitize_html_for_telegram($innerHtml), ['parse_mode' => 'HTML']);
}

else {
    // Send a message for invalid commands
    $bot->sendMessage($chatId, 'Invalid command! Please use one of the following commands: /flipcoin, /rolladice');
}

// The following lines are not needed and can be removed to clean up the code
$bot->sendMessage($botlogger, "Command: $command\nChat ID: $chatId\nMessage ID: $messageId");

