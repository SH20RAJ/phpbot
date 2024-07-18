<?php

// Function to fetch the DNS information using cURL
function fetch_dns_info($url) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
        return false;
    }
    
    curl_close($ch);
    
    return $response;
}

// Function to parse the DNS information from the fetched HTML
function parse_dns_info($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $dns_records = [
        'A' => [],
        'AAAA' => [],
        'MX' => []
    ];

    // Extract A records
    $a_records = $xpath->query("//h2[contains(text(), 'A')]/following-sibling::table[1]//tr");
    foreach ($a_records as $record) {
        $cells = $record->getElementsByTagName('td');
        if ($cells->length == 3) {
            $dns_records['A'][] = [
                'ip' => $cells->item(0)->nodeValue,
                'prefix' => $cells->item(1)->nodeValue,
                'asn' => $cells->item(2)->nodeValue
            ];
        }
    }

    // Extract AAAA records
    $aaaa_records = $xpath->query("//h2[contains(text(), 'AAAA')]/following-sibling::table[1]//tr");
    foreach ($aaaa_records as $record) {
        $cells = $record->getElementsByTagName('td');
        if ($cells->length == 3) {
            $dns_records['AAAA'][] = [
                'ip' => $cells->item(0)->nodeValue,
                'prefix' => $cells->item(1)->nodeValue,
                'asn' => $cells->item(2)->nodeValue
            ];
        }
    }

    // Extract MX records
    $mx_records = $xpath->query("//h2[contains(text(), 'MX Records')]/following-sibling::table[1]//tr");
    foreach ($mx_records as $record) {
        $cells = $record->getElementsByTagName('td');
        if ($cells->length == 5) {
            $dns_records['MX'][] = [
                'priority' => $cells->item(0)->nodeValue,
                'exchange' => $cells->item(1)->nodeValue,
                'ip' => $cells->item(2)->nodeValue,
                'prefix' => $cells->item(3)->nodeValue,
                'asn' => $cells->item(4)->nodeValue
            ];
        }
    }

    return $dns_records;
}

$url = "https://bgp.tools/dns/sh20raj.com";
$html = fetch_dns_info($url);

if ($html === FALSE) {
    echo "Failed to retrieve DNS information.";
} else {
    $dns_info = parse_dns_info($html);

    echo "<h1>DNS Results for sh20raj.com</h1>";

    // Display A records
    echo "<h2>A Records</h2>";
    if (count($dns_info['A']) > 0) {
        echo "<table border='1'><tr><th>IP</th><th>Prefix</th><th>ASN</th></tr>";
        foreach ($dns_info['A'] as $record) {
            echo "<tr><td>{$record['ip']}</td><td>{$record['prefix']}</td><td>{$record['asn']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No A records found.</p>";
    }

    // Display AAAA records
    echo "<h2>AAAA Records</h2>";
    if (count($dns_info['AAAA']) > 0) {
        echo "<table border='1'><tr><th>IP</th><th>Prefix</th><th>ASN</th></tr>";
        foreach ($dns_info['AAAA'] as $record) {
            echo "<tr><td>{$record['ip']}</td><td>{$record['prefix']}</td><td>{$record['asn']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No AAAA records found.</p>";
    }

    // Display MX records
    echo "<h2>MX Records</h2>";
    if (count($dns_info['MX']) > 0) {
        echo "<table border='1'><tr><th>Priority</th><th>Exchange</th><th>IP</th><th>Prefix</th><th>ASN</th></tr>";
        foreach ($dns_info['MX'] as $record) {
            echo "<tr><td>{$record['priority']}</td><td>{$record['exchange']}</td><td>{$record['ip']}</td><td>{$record['prefix']}</td><td>{$record['asn']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No MX records found.</p>";
    }
}

?>
