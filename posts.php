<?php
include_once 'Topic.php';
// GET ./topics.php - vrati vsechny topic

// GET ./topics.php?id=:id - vrati dany topic

// POST ./topics.php - prida topic

// DELETE ./topics.php - odstrani topic
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode(Topic::getAll());
    case 'POST':
        break;
    case 'DELETE':
        break;
}
?>