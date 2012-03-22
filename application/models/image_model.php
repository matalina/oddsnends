<?php
/*
 * Image Model
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Inventory Control
 * @subpackage Models
 */
class Image_model extends CI_Model {
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
  
  /**
   *  Get Image
   */
   function get_image($image_id) {
     $this->main->where('image_id',$image_id);
     $query = $this->main->get('images');
     if($query->num_rows() == 1) {
       return $query->row_array();
     }
     else {
       return false;
     }
   }
   
   function edit_image($image) {
     
   }
   
   function remove_image($image_id) {
     
   }
   
   function new_image($image) {
     
   }
   
   function add_tag($tag,$image_id) {
     
   }
   
   function remove_tag($tag,$image_id) {
     
   }
   
   function new_tag($tag) {
     
   }
   
   function edit_tag($tag) {
     
   }
   
   function remove_tag($tag) {
     
   }
   
   function get_tags($image_id) {
     
   }
   
   function get_tag($tag_id) {
     
   }
   
   function get_image_galleries($image_id) {
     
   }
   
   function get_images_by_tag($tag_id) {
     
   }
   
   function get_image_tags($image_id) {
     
   }
}
  
  