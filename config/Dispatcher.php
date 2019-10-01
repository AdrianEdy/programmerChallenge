<?php
    class Dispatcher
    {
        private $request;

        public function dispatch()
        {
            $this->request = new Request();
            Router::parse($this->request->url, $this->request);

            $controller = $this->loadController();
            call_user_func_array([$controller, $this->request->action], $this->request->params);
        }

        public function loadController()
        {
            $control = ucfirst($this->request->controller);
            $name    = $control . 'Controller';
            $file    = ROOT . 'controller/' . $name . '.php';
            
            require($file);
            $controller = new $name();

            return $controller;
        }
    }
?>