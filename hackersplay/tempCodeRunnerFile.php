<?php
// The URL to fetch the content from
$url = 'https://bgp.he.net/dns/sh20raj.com#_dns';

// Fetch the HTML content
$html_content = fetch_html_content($url);

// Echo the HTML content
echo $html_content;
?>