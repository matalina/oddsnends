<?php
/*
 * Gallery Model
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Inventory Control
 * @subpackage Models
 */
class Gallery_model extends CI_Model {
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
  
  function new_gallery($gallery) {
    $check = $this->main->insert($gallery);
    if($check) {
      return $this->main->insert_id();
    }
    else {
      return FALSE;
    }
  }
  
  function edit_gallery($gallery) {
    $this->main->where('gallery_id',$gallery['gallery_id']);
    $check = $this->main->update($gallery);
    return $check;
  }
  
  function remove_gallery($gallery_id) {
    $this->main->where('gallery_id',$gallery['gallery_id']);
    $check = $this->main->delete($gallery);
    return $check;
  }
  
  function get_gallery($gallery_id) {
    $this->main->where('galley_id',$gallery_id);
    $query = $this->main->get('gallery');
    return $query->row_array();
  }
  
  function get_gallery_images($gallery_id) {
    
  }
  
  function get_public_galleries() {
    
  }
  
  function get_client_galleries($user_id) {
    
  }
  
  function gallery_auth($gallery_id,$password) {
    
  }
}