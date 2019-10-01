<?php
    class Router
    {
        static public function parse($url, $request)
        {
            $url = trim($url);
            if ( $url == '/' ) {
                $request->controller    = 'board';
                $request->action        = 'index';
                $request->params        = [1];
            } else {
                $explode                = explode('/', $url);
                $request->controller    = $explode[1];
                $request->action        = $explode[2];
                $request->params        = array_slice($explode, 3);
            }
        }
    }
?>