<?php

class Controller {

    public function model($model) {
        require_once APPROOT . '/models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data = []) {

        require_once APPROOT . '/views/' . $view . '.php';
    }
}