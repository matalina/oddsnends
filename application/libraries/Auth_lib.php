<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Auth Library
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Inventory Control
 * @subpackage Library
 */
class Auth_lib {
  /**
   * Codeigniter Global
   * @var object
   * @access protected
   */
  protected $ci;
  /**
   * Initlialize Library
   */
  public function __construct() {
    $this->ci =& get_instance();
  }

  /**
   * Checks if a user is logged in
   */
  public function logged_in() {
    if(!$this->ci->session->userdata('user_id') && !$this->ci->session->userdata('username')) {
      redirect('auth/login');
    }
    return TRUE;
  }

  /**
   * Authenticate Access
   * @param string $allowed_groups Groups allowed to view page
   */
  public function authenticate($controller) {
    $groups = explode(',',$this->ci->session->userdata('groups'));
    $this->ci->load->model('Auth_model');
    $allow = $this->ci->Auth_model->get_allowed($controller);
    $check = FALSE;

    foreach($allow as $group) {
      foreach($groups as $grp) {
        if($grp == $group) {
          $check = TRUE;
        }
      }
    }

    if(!$check) {
      redirect('site/homepage');
    }
  }

  /**
   * Log a user out
   */
  public function logout() {
    $this->ci->session->unset_userdata('user_id');
    $this->ci->session->unset_userdata('username');
    $this->ci->session->unset_userdata('groups');
    $this->ci->session->sess_destroy();
  }

  /**
   * Is the user allowed access to this element
   * @param array $allowed controller name
   * @return boolean return true or false
   */
  public function is_allowed($controller) {
    $groups = explode(',',$this->ci->session->userdata('groups'));
    $this->ci->load->model('Auth_model');
    $allow = $this->ci->Auth_model->get_allowed($controller);
    $check = FALSE;

    foreach($allow as $group) {
      foreach($groups as $grp) {
        if($grp == $group) {
          $check = TRUE;
        }
      }
    }

    return $check;
  }
}

/* End of file Auth.php */
