<?php
  session_start();

  // Flash message helper
  // EXAMPLE - flash('register_success', 'Your are now registered', 'alert alert-danger');
  // DISPLAY IN VIEW - echo flash('register_success');
  function flash($name = '', $message = '', $class = 'alert alert-success') {
    if(!empty($name)) {
      if(!empty($message) && empty($_SESSION[$name])) {

        // This is unnecessary
        // unset $_SESSION[$name]
        // if(!empty($_SESSION[$name])) {
        //   unset($_SESSION[$name]);
        // }

        // // unset $_SESSION[$name. '_class']
        // if(!empty($_SESSION[$name . '_class'])) {
        //   unset($_SESSION[$name . '_class']);
        // }

        // set $_SESSION[$name]
        $_SESSION[$name] = $message;
        // set $_SESSION[$name . '_class']
        $_SESSION[$name . '_class'] = $class;

      } elseif(empty($message) && !empty($_SESSION[$name])) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  // Check if it's the user loggedin
  function isLoggedIn() {
    if(isset($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }