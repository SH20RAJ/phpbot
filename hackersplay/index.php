<?php
require __DIR__ . '/../phpgram.php'; // Adjust the path to your Telegram bot library
require __DIR__ . '/dns.php'; // Adjust the path as needed

use PhpGram\PhpGram;

// Replace with your bot token
$botToken = '7227210007:AAGYF1Rvk4cJZNtshC-2TYbn6I7TiAstb-c'; // Replace with your actual bot token
$bot = new PhpGram($botToken);

// Get the incoming message and chat ID
$update = json_decode(file_get_contents('php://input'), true);
$chatId = $update['message']['chat']['id'];
$command = trim($update['message']['text']);

// Function to fetch HTML content
function fetch_html_content($url) {
    return file_get_contents($url); // Replace with your own implementation to fetch HTML content
}

// Function to sanitize HTML for Telegram
function sanitize_html_for_telegram($html) {
    // Define allowed tags and attributes
    $allowed_tags = ['b', 'i', 'a', 'code', 'pre', 'strong', 'em', 'u', 'br'];
    $allowed_attributes = ['href', 'title'];

    // Remove unsupported tags and attributes
    $html = strip_tags($html, '<' . implode('><', $allowed_tags) . '>');
    $html = preg_replace('/<a\s+(?:[^>]+\s+)?href="([^"]+)"(?:[^>]+\s+)?>(.*?)<\/a>/i', '<a href="$1">$2</a>', $html); // Preserve href attribute

    // Convert special characters to HTML entities
    $html = htmlspecialchars($html);

    // Remove leading and trailing whitespace
    $html = trim($html);

    return $html;
}

// Handle commands
if ($command == '/start') {
    // Send a welcome message
    $bot->sendMessage($chatId, 'Welcome to the bot! ✨ You can use the following commands: /flipcoin, /rolladice');
} elseif (strpos($command, '/dns') === 0) {
    $url = substr($command, 5);
    $url = 'https://bgp.he.net/dns/' . $url;
    
    // Fetch HTML content
    $html = fetch_html_content($url);
    
    // Extract inner HTML by ID (you need to implement this function)
    $innerHtml = extract_inner_html_by_id($html, 'dns');

    // Sanitize HTML for Telegram
    $sanitizedHtml = sanitize_html_for_telegram($innerHtml);

    // Send sanitized HTML to Telegram
    $bot->sendMessage($chatId, $sanitizedHtml, ['parse_mode' => 'HTML']);
} else {
    // Send a message for invalid commands
    $bot->sendMessage($chatId, 'Invalid command! Please use one of the following commands: /flipcoin, /rolladice');
}
?>
