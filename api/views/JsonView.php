<?php

class JsonView extends NumberGuessView {
    public function render($content) {
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($content);
        return true;
    }
}

?>
