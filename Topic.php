<?php
include_once 'Post.php';

$mysqli = new mysqli('localhost', 'root', '', 'projectX');

class Topic {

    public $id;
    public $name;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    public function getPosts() {
        global $mysqli;
        $posts;
        $results = $mysqli->query("SELECT * FROM posts WHERE topicid='$this->id'");

        if(!$results) {
            die("program crashed $results");
        }

        while ($row = $results->fetch_assoc()) {
            $posts[] = new Post($row);
        }
        $results->free();
        return $posts;
    }

    public function remove() {
        global $mysqli;

        $results = $mysqli->query("DELETE FROM topics WHERE id='$this->id' AND name='$this->name'");

        return $mysqli->affected_rows;
    }

    static function getAll() {
        global $mysqli;
        $topics;
        $results = $mysqli->query("SELECT * FROM topics");

        if(!$results) {
            die('program crashed');
        }
        while ($row = $results->fetch_assoc()) {
            $topics[] = new Topic($row);
        }
        $results->free();
        return $topics;
    }

    static function create($name) {
        global $mysqli;
        $results = $mysqli->query("INSERT INTO topics (name) VALUES ('$name')");

        if (!$results) {
            die('program crashed');
        }

        $id = $mysqli->insert_id;

        return new Topic(array('id'=>$id,'name'=>$name));
    }
}
?>