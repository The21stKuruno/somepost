<?php
/*
* App Core Class
* Creates URL & load core controller
* Url Format - /controller/method/params
*/

class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    // print_r($this->getUrl());

    $url = $this->getUrl();

    // Look in controllers for first value
    // ucwords()-method = capitalize the first letter of the string
    if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
      // If exists, set as controller
      $this->currentController = ucwords($url[0]);
      // Unset 0 Index
      unset($url[0]);
    }

    // Require the controller
    require_once '../app/controllers/' . $this->currentController . '.php';

    // Instantiate controller class
    $this->currentController = new $this->currentController;

    // Check the second part of url
    if(isset($url[1])) {
      // Check to see if method exists in controller
      if(method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        // Unset 1 Index
      unset($url[1]);
      }
    }

    // It's called a ternary statement.  [value] = [condition] ? [if true] : [else].
    // Long code for ternary statement

    // if($url) {
    //   $this->params = array_values($url);
    // }else {
    //     $this->params = [];
    // }
    
    // Get params
    $this->params = $url ? array_values($url) : []; // Short code, Better than the code above

    // Call a callback with array of params
   call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl() {
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/'); // rtrim remove the slash(/) character from the right side of the $url string
      $url = filter_var($url, FILTER_SANITIZE_URL); //removes all illegal URL characters from a string
      $url = explode('/', $url);
      return $url;
    }
  }
}