<?php

$inputString = '{{1,500},{2,600},{3,700,好,a.mp3},{4,500,1.jpg}}';

// Remove the outer curly braces
$inputString = trim($inputString, '{}');

// Split the string into individual elements
$elements = explode('},{', $inputString);

$data = [];

foreach ($elements as $element) {
    // Split each element into its parts (assuming they are separated by commas)
    $parts = explode(',', $element);

    // Create an associative array for each part
    $item = [];
    foreach ($parts as $part) {
        $item[] = $part;
    }

    // Add the item to the data array
    $data[] = $item;
}

// Encode the data as JSON
$jsonData = json_encode($data);

echo $jsonData;

$escapedJsonData = mysqli_real_escape_string($conn, $jsonData);
