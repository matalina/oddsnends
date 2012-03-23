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
    $check = $this->main->insert('page',$page);
    if($check) {
      return $this->main->insert_id();
    }
    else {
      return FALSE;
    }
  }
  
  function edit_page($page) {
    $this->main->where('page_id',$page['page_id']);
    $check = $this->main->update('page',$page);
    return $check;
    
  }
  
  function remove_page($page_id) {
    $this->main->where('page_id',$page_id);
    $check = $this->main->delete('page');
    return $check;
  }
  
  function get_page_by_id($page_id) {
    $this->main->where('page_id',$page_id);
    $query = $this->main->get('page');
    return $query->row_array();
  }
  
  function get_page_by_stub($stub) {
    $this->main->where('stub',$stub);
    $query = $this->main->get('page');
    return $query->row_array();
  }
}