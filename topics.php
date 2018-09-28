<?php
include_once 'Topic.php';
// GET ./topics.php - vrati vsechny topic

// GET ./topics.php?id=:id - vrati dany topic

// POST ./topics.php - prida topic

// DELETE ./topics.php - odstrani topic
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$data = json_decode(file_get_contents("php://input"));

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode(Topic::getAll());
        break;
    case 'POST':
        if (!property_exists($data, 'name')) {
            echo '{"error":"You have to provide topic name"}';
            break;
        }
        $topic = Topic::create($data->name);
        if (!$topic) {
            echo '{"error":"Error when inserting new topic"}';
            break;
        }

        echo json_encode($topic);

        break;
    case 'DELETE':
        if (!property_exists($data, 'name') || !property_exists($data, 'id')) {
            echo '{"error":"You have to provide topic name and id"}';
            break;
        }

        $topic = new Topic(['id'=>$data->id,'name'=>$data->name]);

        if ($num = $topic->remove()) {
            echo sprintf('{"success":"Topic %s deleted; Affetced rows: %s"}', $data->id, $num);
        } else {
            echo sprintf('{"error":"Something bad happened"}');
        }

        break;
}
?>