<?php
/**
 * Base Controller for Authentication
 * @package Project Name
 * @author Alicia Wilkerson
 * @version 0.1.0
 */

/**
 * @package Project Name
 * @subpackage Controllers
 */
class RA_Controller extends CI_Controller {
  /**
   * Initialize Controller
   */
  public function __construct($controller = FALSE) {
    parent::__construct();
    $this->load->model('Auth_model');
    $this->config->load('Auth_lib');
    
    if($controller) {
      if(!$this->auth_lib->logged_in())  {
        redirect('auth/login');
      }
      $this->auth_lib->authenticate($controller);
    }  
  }
  
}  