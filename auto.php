<?php
$mysqli = new mysqli('localhost', 'root', '', 'projectX');

class Auto {
    public $color;

    public function __construct($color='bilá') {
        $this->color = $color;
    }
}

class Auto2 extends Auto {
    private $running = false;

    public function state() {
        return $this->running;
    }

    public function start() {
        $this->running = true;
    }
}

$auto1 = new Auto('cervena');
$auto2 = new Auto('modrá');
$auto3 = new Auto();
$auto4 = new Auto2('cerna');

printf('%s<br>',$auto1->color);
printf('%s<br>',$auto2->color);
printf('%s<br>',$auto3->color);

printf('%s<br>',$auto4->color);

class Topic {

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    public function getPosts() {
        global $mysqli;
        $posts = [];
        $query = sprintf('SELECT * FROM posts WHERE id=\'%s\'', $this->id);
        if ($result = $mysqli->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }


            /* free result set */
            $result->free();
                    }

        return $posts;
    }

    static function getAll() {
        global $mysqli;
        $query = 'SELECT * FROM topics';
        $topics = [];
        if ($result = $mysqli->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $topics[] = new Topic($row);
            }


            /* free result set */
            $result->free();
        }

        return $topics;
    }
}

$topics = Topic::getAll();
var_dump($topics);
printf('%s<br>',$topics[0]->name);
var_dump($topics[0]->getPosts());


?>