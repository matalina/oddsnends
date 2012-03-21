<?php
/**
 * Extended Form Validation Library
 * @package Project Name
 * @author Alicia Wilkerson
 * @version 0.1.0
 */

/**
 * @package Project Name
 * @subpackage Libraries
 */
class MY_Form_validation extends CI_Form_validation {
  /**
   * Initialize Controller
   */
  public function __construct($controller = FALSE) {
    parent::__construct();
  }
  
  /**
   * Zip Code Validator
   */
  public function valid_zip($zip) {
    if(!preg_match('/^\d{5}(\-\d{4})*$/',$zip)) {
      return FALSE
    }
    else {
      return TRUE;
    }
  }
  
  /**
   * Phone Number Validator
   */
  public function valid_phone($phone) {
    if(!preg_match('/^\(*\d{3}\)*[ \-]*\d{3}[ \-]*\d{4}$/',$phone)) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }
  
  
}  