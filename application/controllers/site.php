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
   * @access public
   */
  public function index() {
    $data['title'] = 'Home';
    $data['id'] = 'home';
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
    redirect('site/index');
  }

  /**
   * Pending Page for those who do not have an activated account
   * @access public
   */
  public function pending() {
    $this->session->set_flashdata('warning','<div class="warning">You have not activated your account.</div>');
    redirect('site/index');
  }
  
  /**
   * Get Page and Display
   * @access public
   */
  public function page($slug,$ajax = false) {
    $this->load->model('Page_model');
    $this->load->library('typography');
    $page = $this->Page_model->get_page_by_slug($slug);
    $data['page'] = $page;
    if(!$ajax) { // if not ajax load view with template
      $data['title'] = $page['name'];
      $this->template->load('templates/site','site/content',$data);
    }
    else { // else echo page contents
      $this->load->template('site/content',$data);
    }
  }
  
  /**
   * View Galleries
   */
   public function gallery($gallery_id = 1) {
     
   }
}
