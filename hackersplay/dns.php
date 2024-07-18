<?php
// Function to fetch HTML content from a URL
function fetch_html_content($url) {
    // Initialize cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
    
    // Execute cURL session
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Return the fetched HTML content
    return $response;
}

function extract_inner_html_by_id($html, $id) {
    // Create a DOMDocument instance
    $dom = new DOMDocument();
    
    // Load HTML content
    libxml_use_internal_errors(true); // Disable libxml errors
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    // Create a DOMXPath instance
    $xpath = new DOMXPath($dom);
    
    // Find the element by ID
    $element = $xpath->query("//*[@id='$id']")->item(0);
    
    if ($element) {
        // Extract inner HTML of the found element
        $inner_html = '';
        foreach ($element->childNodes as $node) {
            $inner_html .= $dom->saveHTML($node);
        }
        
        return $inner_html;
    } else {
        return null; // Return null if element with given ID is not found
    }
}
function sanitize_html_for_telegram($html) {
    // Define allowed tags and attributes
    $allowed_tags = ['b', 'i', 'a', 'code', 'pre', 'strong', 'em', 'u', 'br'];
    $allowed_attributes = ['href', 'title'];

    // Remove unsupported tags and attributes
    $html = strip_tags($html, '<' . implode('><', $allowed_tags) . '>');
    $html = preg_replace('/<a\s+(?:[^>]+\s+)?href="([^"]+)"(?:[^>]+\s+)?>(.*?)<\/a>/i', '<a href="$1">$2</a>', $html); // Preserve href attribute

    // Convert special characters to HTML entities
    $html = htmlspecialchars($html);

    return $html;
}


// The URL to fetch the content from
$url = 'https://bgp.he.net/dns/sh20raj.com#_dns';

// Fetch the HTML content
$html_content = fetch_html_content($url);

// Echo the HTML content
echo extract_inner_html_by_id($html_content, 'dns');


?>
