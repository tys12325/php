<?php
// Set the path to the XML file
$xmlFilePath = '../exports/products.xml';

// Check if the XML file exists
if (file_exists($xmlFilePath)) {
    // Load the XML file
    $xml = simplexml_load_file($xmlFilePath);

    // Convert the XML object to a JSON-encoded array
    $json = json_encode($xml, JSON_PRETTY_PRINT);

    // Set the content type to JSON and output the JSON data
    header('Content-Type: application/json');
    echo $json;
} else {
    // Return an error if the file does not exist
    header("HTTP/1.0 404 Not Found");
    echo json_encode(["error" => "XML file not found."]);
}
