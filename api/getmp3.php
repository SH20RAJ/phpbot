<?php
// URL of the file to be downloaded
$fileUrl = 'https://aac.saavncdn.com/665/7790c3b9097592113008eaf1031d6e57_320.mp4';

// Custom name for the downloaded file
$downloadFileName = 'song-name.mp3';

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
