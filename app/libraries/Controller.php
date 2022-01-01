<?php

class Controller {

    public function model($model) {
        $path = APPROOT . '/models/' . $model . '.php';
        require_once $path;
        //instantiate a model
        return new $model();
    }

    public function view($view, $data = []) {
        //$path = $_SERVER['DOCUMENT_ROOT'].'/mvcblog/app/views/' . $view . '.php';
        $path = APPROOT . '/views/' . $view . '.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            die('view does not exist');
        }
    }
}