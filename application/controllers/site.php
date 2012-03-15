<?php
/**
 * Site Controller
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 0.1.0
 */

/**
 * @package Inventory Control
 * @subpackage Controllers
 */
class Site extends CI_Controller {
  /**
   * Initialize Controller
   * @access public
   */
  public function __construct() {
    parent::__construct();
  }
  /**
   * Redirect
   */
  public function index() {
    $data['title'] = 'Home';
    $this->template->load('templates/site','site/home',$data);
  }

  /**
   * Default Home Page
   * @access public
   */
  public function homepage() {
    $this->load->library('Auth_lib');
    if(!$this->auth_lib->logged_in())  {
      redirect('auth/login');
    }
    $this->auth_lib->authenticate('member');
    $this->session->set_flashdata('success','<div class="success">You have successfully logged in.</div>');
    if(is_allowed('client')) {
      redirect('client/index');
    }
    else if(is_allowed('admin')) {
      redirect('admin/index');
    }    
    else {
      redirect('site/index');
    }
  }

  /**
   * Pending Page for those who do not have an activated account
   */
  public function pending() {
    $this->session->set_flashdata('warning','<div class="warning">You have not activated your account.</div>');
    redirect('site/index');
  }
}
