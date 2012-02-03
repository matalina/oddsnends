<?php
/**
 * Inventory Control
 * @package Project Name
 * @author Alicia Wilkerson
 * @version 1.0.0
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package Inventory Control
 * @subpackage Libraries
 */
class Template {
  /**#@+
   * @var array
   * @access protected
   */
  protected $template_data = array();
  /**#@-*/

  /**
   * Set Template data
   * @param string $name The name of the templae data to replace
   * @param mixed $value The value for the data to be set to
   */
  function set($name, $value) {
    $this->template_data[$name] = $value;
  }

  /**
   * Create Page View
   * @param string $template The name of the template to be used
   * @param string $view The name of the view to be used
   * @param array $view_data All of the view data to be passed to the view
   * @param boolean $return FALSE to Return to broswer or TRUE as string
   */
  function load($template = '', $view = '' , $view_data = array(), $return = FALSE) {
    $this->CI =& get_instance();
    $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
    return $this->CI->load->view($template, $this->template_data, $return);
  }
}

/* End of file Template.php */
/* Location: ./application/libraries/template.php */
