<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        // print_r($this->getUrl());

        $url = $this->getUrl();

        // Look in controllers for first value
        if(file_exists('app/controllers/' . ucwords($url[0] ?? '') . '.php')){
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once 'app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if(isset($url[1])){
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
        // 1. Check $_GET['url'] (from .htaccess rewrite)
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        } 
        
        // 2. Check PATH_INFO (for index.php/controller/method)
        if(isset($_SERVER['PATH_INFO'])){
             $url = rtrim($_SERVER['PATH_INFO'], '/');
             $url = filter_var($url, FILTER_SANITIZE_URL);
             $url = explode('/', $url);
             if(empty($url[0])){
                 array_shift($url);
             }
             return $url;
        }

        // 3. Fallback: Parse REQUEST_URI manually
        $requestUri = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);

        // Remove query string
        if (false !== $pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }

        // Extract path from URI
        $url = '';
        if (strpos($requestUri, $scriptName) === 0) {
            $url = substr($requestUri, strlen($scriptName));
        } elseif (strpos($requestUri, $scriptDir) === 0) {
            $url = substr($requestUri, strlen($scriptDir));
        } else {
            // If request URI does not start with script dir (e.g. rewrite is working but passing wrong params)
            // Just use the request URI
            $url = $requestUri;
        }

        $url = trim($url, '/');
        if(!empty($url)){
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }

        return [];
    }
}
