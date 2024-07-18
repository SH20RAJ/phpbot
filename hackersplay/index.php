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
    $innerHtml = `
    Start of Authority
  
   
    
     mname:  ns1.dns-parking.com
     rname:  dns.hostinger.com<br>
     serial:  2024071801<br>
     refresh: 10000
     retry:  2400<br>
     expire:  604800
     minimum: 600
    
   
  
 
 
 
  Nameservers
  
   <a href="/dns/ns1.dns-parking.com" title="ns1.dns-parking.com">ns1.dns-parking.com</a>, <a href="/dns/ns2.dns-parking.com" title="ns2.dns-parking.com">ns2.dns-parking.com</a>
  
  
 
 
  Mail Exchangers
  
   <a href="/dns/mx2.hostinger.com" title="mx2.hostinger.com">mx2.hostinger.com</a>(10)
   
 
 
 
  TXT Records
  
   
    
     v=spf1 include:_spf.mail.hostinger.com ~all<br>
    
    <br>
   
  
 
 
 
  A Records
  
   <a href="/ip/216.239.36.21" title="216.239.36.21">216.239.36.21</a>, <a href="/ip/216.239.34.21" title="216.239.34.21">216.239.34.21</a>, <a href="/ip/216.239.32.21" title="216.239.32.21">216.239.32.21</a>, <a href="/ip/216.239.38.21" title="216.239.38.21">216.239.38.21</a>
  
 

 
  AAAA Records
  
   <a href="/ip/2A02:4780:2B:1610::CAB:4D71:2" title="2A02:4780:2B:1610::CAB:4D71:2">2A02:4780:2B:1610::CAB:4D71:2</a>
    `;
    $bot->sendMessage($chatId, $innerHtml, ['parse_mode' => 'HTML']);
    // $bot->sendMessage($chatId, sanitize_html_for_telegram($innerHtml), ['parse_mode' => 'HTML']);

}




else {
    // Send a message for invalid commands
    $bot->sendMessage($chatId, 'Invalid command! Please use one of the following commands: /flipcoin, /rolladice');
}
