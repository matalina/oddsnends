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
}
  
  