<?php
// Check if URL and name parameters are provided in the query string
if (!isset($_GET['url']) || !isset($_GET['name'])) {
    die('URL and name parameters are required.');
}

// Get the URL and name from the query string
$fileUrl = $_GET['url'];
$downloadFileName = $_GET['name'];

// Fetch the file content from the URL
$fileContent = file_get_contents($fileUrl);

if ($fileContent === false) {
    // Handle error if file content could not be fetched
    die('Failed to fetch file content.');
}

// Set headers to force download as an MP3 file
header('Content-Description: File Transfer');
header('Content-Type: audio/mpeg');
header('Content-Disposition: attachment; filename="' . $downloadFileName . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($fileContent));

// Output the file content
echo $fileContent;
exit;
?>
