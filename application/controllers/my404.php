<?php
/**
 * Error Controller
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 0.1.0
 */

/**
 * @package Inventory Control
 * @subpackage Controllers
 */
class my404 extends CI_Controller {
  /**
   * Initialize Controller
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Displays a custom error pages on 404 errors
   */
  public function index()     {
    $this->load->library('Template');
    $this->output->set_status_header('404');
    $data['content'] = 'error_404'; // View name
    $data['title'] = '404 Error - File Not Found';
    $this->template->load('templates/full_page_layout','site/404_error',$data);//loading in my template
  }
}
