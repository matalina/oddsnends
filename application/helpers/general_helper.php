<?php
/*
 * General Helper
 * @package Inventry Control
 * @subpackage Helpers
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
  * Generic Drop Down Array Generator
  * @param array $array A generic array to use as a basis
  * @param string $id the name of the key to be used as an key value
  * @param string $value the field that is to be used as the value
  * @return array returns an array for a drop down list
  */
 function make_dropdown($array, $id, $value) {
   $dd = array();
   foreach($array as $arr) {
     $dd[$arr[$id]] = $arr[$value];
   }
   return $dd;
 }

   /**
   * Is this a Valid Date?
   */
  function valid_date($date) {
    if(preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Is this a Valid filename
   */
  function valid_filename($filename) {
    $pattern = '/^[a-zA-Z0-9]+_\d*_*\d{4}_\d{2}_\d{2}_*\d{0,4}_*\d{0,2}_*\d{0,2}\.csv$/';

    if(preg_match($pattern,$filename)) {
      return TRUE;
    }
    else
      return FALSE;
  }
