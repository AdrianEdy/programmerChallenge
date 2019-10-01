<?php
    class Controller
    {
        public $vars = [];
        public $pagination;

        public function set($data)
        {
            $this->vars = $data;
        }

        public function render($fileName)
        {
            extract($this->vars);

            $content    = ROOT . 'views/' . $fileName;
            $pagination = $this->pagination;

            require(ROOT . 'views/layout.php');
        }
    }
?>