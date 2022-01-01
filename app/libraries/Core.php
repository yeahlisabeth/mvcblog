<?php

//Core app class
class Core {
    //if there are no other controllers in the controller file, this page will be automatically loaded
    //the currentController and the currentMethod will change if the URL changes
    protected $currentController = 'PagesController';
    //inside the PageController, it will load the index method
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        //if (file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
        if (isset($url) && file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            //will set a new controller
            $this->currentController = ucwords($url[0]) . 'Controller';
            unset($url[0]);
        }

        //require the controller
        require '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        //check gor the second part of the url
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        //get params: checking if there are any params and if there is not - keep it empty
        $this->params = $url ? array_values($url) : [];

        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            //filter variables as a string or a number
            //not allowing characters that url shouldn't have
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //break url into an array
            $url = explode('/', $url);
            return $url;
        }
    }
}
