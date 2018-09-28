<?php
$mysqli = new mysqli('localhost', 'root', '', 'projectX');

class Post {
    public $id;
    public $topicid;
    public $postid;
    public $user;
    public $email;
    public $text;
    public $date;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->topicid = $data['topicid'];
        $this->postid = $data['postid'];
        $this->user = $data['user'];
        $this->email = $data['email'];
        $this->text = $data['text'];
        $this->date = $data['date'];
    }

    public function getReactions() {
        $reactions; // instace Post
        // ziskat data z sql
        $results = $mysqli->query("SELECT * FROM posts WHERE postid='$this->id'");

        while ($row = $result->fetch_assoc()) {
            $reactions[] = new Post($row);
        }

        $result->free();

        return $reactions;
    }

    static function create($user, $email, $text, $topicid, $postid=null) {

        $date = date("Y-m-d H:i:s");
        $results = $mysqli->query("INSERT INTO posts (user, email, text, date, topicid, postid) VALUES ('$user', '$email', '$text', '$date', '$topicid', '$postid')");

        if (!$results) {
            die('program crashed');
        }

        $id = $mysqli->insert_id;

        return new Post(array('id'=>$id, 'user'=>$user, 'email'=>$email, 'text'=>$text, 'date'=>$date));
    }

    static function getByTopic($id) {
        $posts;
        $results = $mysqli->query("SELECT * FROM posts WHERE topicid='$id'");
        if (!$results) {
            die('program crashed');
        }
        while($row = $results->fetch_assoc()) {
            $posts[] = new Post($row);
        }

        $results->free();

        return $posts;
    }
}

$mysqli->close();
?>