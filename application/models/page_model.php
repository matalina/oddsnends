<?php
/*
 * Page Model
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Inventory Control
 * @subpackage Models
 */
class Page_model extends CI_Model {
  /**#@+
   * @var object
   * @access private
   */
  private $main; // Main Database
  /**#@-*/

  /**
   * Initialize Model
   */
  function __construct() {
    parent::__construct();
    // Load Databases
    $this->main = $this->load->database('default',TRUE);
  }
  
  function new_page($page) {
    
  }
  
  function edit_page($page) {
    
  }
  
  function remove_page($page_id) {
    
  }
  
  function get_page_by_id($page_id) {
    
  }
  
  function get_page_by_stub($stub) {
    
  }
}