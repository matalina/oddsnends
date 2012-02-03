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
    $this->homepage();
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

    $data['title'] = 'Base Home Page';
    $this->template->load('templates/two_column_layout','site/home',$data);
  }

  /**
   * Pending Page for those who do not have an activated account
   */
  public function pending() {
    $data['title'] = 'Pending Home Page';
    $this->template->load('templates/one_column_layout','site/pending',$data);
  }
}
