<?php
/*
 * Auth Model
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Inventory Control
 * @subpackage Models
 */
class Auth_model extends CI_Model {
  /**#@+
   * @var object
   * @access private
   */
  private $auth; // Auth Database
  /**#@-*/

  /**
   * Initialize Model
   */
  function __construct() {
    parent::__construct();
    // Load Databases
    $this->auth = $this->load->database('default',TRUE);
  }

  /**
   * Register a new user
   * @param array $user_info an array of user information
   * @return string|boolean returns activation code or false if not created
   */
  function register($user_info) {
    $username = $user_info['username'];
    $password = $this->encrypt_password($user_info['password']);
    $email = $user_info['email'];
    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    $created_on = date('Y-m-d H:i:s');

    // Gather IP info from Browser
    $HTTP_CLIENT_IP = getenv('HTTP_CLIENT_IP');
    $HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];

    // Find IP Address of Visitor
    if (!empty($HTTP_CLIENT_IP)) {
      $ip = $HTTP_CLIENT_IP;
    }
    elseif (!empty($HTTP_X_FORWARDED_FOR)) {
      $ip = $HTTP_X_FORWARDED_FOR;
    }
    else{
      $ip = $REMOTE_ADDR;
    }
    // Add info to user table
    $this->auth->set('username',$username);
    $this->auth->set('password',$password);
    $this->auth->set('email',$email);
    $this->auth->set('created_on',$created_on);
    $this->auth->set('active',0);
    $this->auth->set('ip_address',$ip);
    $check = $this->auth->insert('users');
    // get user id of new row or return false
    if($check) {
      $user_id = $this->auth->insert_id();
    }
    else {
      return FALSE;
    }
    // add info to meta table
    $this->auth->set('user_id',$user_id);
    $this->auth->set('first_name',$first_name);
    $this->auth->set('last_name',$last_name);
    $this->auth->insert('meta');
    // add info to codes table
    $this->auth->set('user_id',$user_id);
    $this->auth->set('code_id',sha1($created_on));
    $this->auth->set('code_type','A'); // Activate Code Type
    $this->auth->set('expires_on',date('Y-m-d H:i:s',strtotime('+1 day',strtotime($created_on))));
    $this->auth->insert('codes');

    // Add to base usergroup
    $auth_default_group = $this->config->item('auth_default_group');
    
    $this->auth->set('user_id',$user_id);
    $this->auth->set('group_id',$auth_default_group);
    $this->auth->insert('user_groups');

    return sha1($created_on);
  }

  /**
   * Encrypt password
   * @param string $password user supplied password
   * @param string $salt password salt
   */
  function encrypt_password($password, $salt = '') {
    if($salt == '') {
      $salt = $this->generate_salt();
    }
    $comb_pass_salt = $salt.$password;
    $encrypt_password = sha1($comb_pass_salt);
    $salted_password = $salt.$encrypt_password;

    return $salted_password;
  }

  /**
   * Generate Salt
   * @return string returns 10 character salt
   */
  function generate_salt() {
    $salt = substr(md5(uniqid()),0,10);
    return $salt;
  }

  /**
   * Get Salt from encrypted password in database
   * @param string $password an encrypted password in database
   * @return string return 10 character salt
   */
  function get_salt($password) {
    $salt = substr($password,0,10);
    return $salt;
  }

  /**
   * Activate Account
   * @param string $code sha1 of created_on to provide proof of activation
   * @param boolean returns true if successful false if not
   */
  function activate($code) {
    $code = (string)$code;
    $this->auth->where('code_id',$code);
    $this->auth->where('expires_on >',date('Y-m-d H:i:s'));
    $this->auth->where('code_type','A');
    $query= $this->auth->get('codes');

    if($query->num_rows() == 1) {
      $result = $query->row_array();
      $this->auth->where('user_id',$result['user_id']);
      $this->auth->where('sha1(created_on) = \''.$code.'\'');
      $query = $this->auth->get('users');

      if($query->num_rows() == 1) {
        $user = $query->row_array();

        $this->auth->where('user_id',$user['user_id']);
        $this->auth->set('active',1);
        $this->auth->update('users');

        $this->auth->where('code_id',$code);
        $this->auth->delete('codes');
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Login
   * @param string $username user supplied username
   * @param string $password user supplied password
   * @return boolean returns true if successful and false if not
   */
  function login($username,$password) {
    $this->auth->where('username',$username);
    $this->auth->where('active','1');
    $query = $this->auth->get('users');
    if($query->num_rows() == 1) {
      $user = $query->row_array();
      $salt = $this->get_salt($user['password']);

      $encrypt_password = $this->encrypt_password($password,$salt);

      if($encrypt_password === $user['password']) {
        return $user['user_id'];
      }
    }
    return FALSE;
  }

  /**
   * Lost Password function
   * @param string $email an email address to search for
   * @return string|boolean returns lost password code or false if not successful
   */
  function lost_password($email) {
    $this->auth->where('email',$email);
    $query = $this->auth->get('users');

    if($query->num_rows() == 1) {
      $user = $query->row_array();

      $this->auth->where('user_id',$user['user_id']);
      $this->auth->where('code_id',sha1($user['password']));
      $this->auth->where('code_type','L');
      $check = $this->auth->get('codes');
      // If the code doesn't already exist
      if($check->num_rows() == 0) {
        $this->auth->set('user_id',$user['user_id']);
        $this->auth->set('code_id',sha1($user['password']));
        $this->auth->set('expires_on',date('Y-m-d H:i:s',strtotime('+1 day')));
        $this->auth->set('code_type','L'); // Lost Password Code Type
        $check = $this->auth->insert('codes');

        if($check) {
          return sha1($user['password']);
        }
      }
      // If the code does exist
      else {
        $this->auth->where('user_id',$user['user_id']);
        $this->auth->where('code_id',sha1($user['password']));
        $this->auth->where('code_type','L'); // Lost Password Code Type
        $this->auth->set('expires_on',date('Y-m-d H:i:s',strtotime('+1 day')));
        $check = $this->auth->update('codes');

        return sha1($user['password']);
      }
    }
    return FALSE;
  }

  /**
   * Verify Lost Password Code
   * @param string $code a string to verify user password is to be changed
   * @return boolean return true if valid, false if not
   */
  function verify_lost_password($code) {
    $this->auth->where('code_id',$code);
    $this->auth->where('expires_on >',date('Y-m-d H:i:s'));
    $this->auth->where('code_type','L');
    $query= $this->auth->get('codes');

    if($query->num_rows() == 1) {
      $codes = $query->row_array();

      $this->auth->where('user_id',$codes['user_id']);
      $query = $this->auth->get('users');

      if($query->num_rows() == 1) {
        $user = $query->row_array();


        if($code === sha1($user['password'])) {
          return $user['user_id'];
        }
      }
    }
    return FALSE;
  }

  /**
   * Reset a given users password
   * @param int $user_id a specific users id
   * @param string $password new password
   * @return boolean returns true if successful false if not
   */
  function reset_password($user_id,$password) {
    $encrypted_password = $this->encrypt_password($password);
    $this->auth->where('user_id',$user_id);
    $this->auth->set('password',$encrypted_password);
    $check = $this->auth->update('users');

    if($check) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Set User to Group
   * @param int $user_id A specific user id
   * @param int $group_id A specific group id
   * @return boolean returns true if successful false if not
   */
  function set_group($user_id,$group_id) {
    $this->auth->set('user_id',$user_id);
    $this->auth->set('group_id',$group_id);
    $check = $this->auth->insert('user_groups');

    if($check) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Remove from Group
   * @param int $user_id A specific user id
   * @param int $group_id A specific group id
   * @return boolean returns true if successful false if not
   */
  function remove_group($user_id,$group_id) {
    $this->auth->where('user_id',$user_id);
    $this->auth->where('group_id',$group_id);
    $check = $this->auth->delete('user_groups');

    if($check) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Deactiate User
   * @param int $user_id A specific user id
   * @return boolean returns true if successful false if not
   */
  function deactivate_user($user_id) {
    $this->auth->where('user_id',$user_id);
    $this->auth->set('active',0);
    $check = $this->auth->update('users');

    if($check) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Actiate User
   * @param int $user_id A specific user id
   * @return boolean returns true if successful false if not
   */
  function activate_user($user_id) {
    $this->auth->where('user_id',$user_id);
    $this->auth->set('active',1);
    $check = $this->auth->update('users');

    if($check) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Get All Users
   */
  function get_users() {
    $this->auth->join('meta','users.user_id = meta.user_id');
    $this->auth->order_by('last_name');
    $this->auth->order_by('first_name');
    $query = $this->auth->get('users');
    return $query->result_array();
  }

  /**
   * Get a User
   */
  function get_user($user_id) {
    $this->auth->where('users.user_id',$user_id);
    $this->auth->join('meta','users.user_id = meta.user_id');
    $this->auth->order_by('last_name');
    $this->auth->order_by('first_name');
    $query = $this->auth->get('users');
    return $query->row_array();
  }

  /**
   * Get User's groups
   */
  function get_user_groups($user_id) {
    $this->auth->where('user_id',$user_id);
    $query = $this->auth->get('user_groups');
    $results =  $query->result_array();
    $groups = array();
    foreach($results as $row) {
      $groups[] = $row['group_id'];
    }
    return $groups;
  }

  /**
   * Get User's groups
   */
  function get_user_groups_more($user_id) {
    $this->auth->where('user_id',$user_id);
    $this->auth->join('groups','user_groups.group_id = groups.id');
    $query = $this->auth->get('user_groups');
    $results =  $query->result_array();

    return $results;
  }

  function unique_username($data) {
    $this->auth->where('username',$data);
    $query = $this->auth->get('users');

    if($query->num_rows() > 0) {
      return FALSE;
    }

    return TRUE;
  }

  function unique_email($data) {
    $this->auth->where('email',$data);
    $query = $this->auth->get('users');

    if($query->num_rows() > 0) {
      return FALSE;
    }

    return TRUE;
  }

  function email_exists($data) {
    $this->auth->where('email',$data);
    $query = $this->auth->get('users');

    if($query->num_rows() != 1) {
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Get Store ID for a user
   */
  function get_store($user_id) {
    $this->auth->where('user_id',$user_id);
    $query = $this->auth->get('meta');
    $store = $query->row_array();
    return $store['store_id'];
  }

  /**
   * Edit a User
   */
  function edit_user($info) {
    $this->auth->where('user_id',$info['user_id']);
    $this->auth->set('email',$info['email']);
    $this->auth->update('users');

    $this->auth->where('user_id',$info['user_id']);
    $this->auth->set('first_name',$info['first_name']);
    $this->auth->set('last_name',$info['last_name']);
    $this->auth->set('store_id',$info['store_id']);
    $query = $this->auth->update('meta');

    if($query) {
      return TRUE;
    }
    else {
      return FALSE;
    }

  }

  /**
   * Get all groups
   */
  function get_groups() {
    $query = $this->auth->get('groups');
    return $query->result_array();
  }

  /**
   * Get Controller Groups
   */
  function get_allowed($controller) {
    $this->auth->where('ctrl_uri',$controller);
    $this->auth->join('controller','permissions.ctrl_id = controller.ctrl_id');
    $query = $this->auth->get('permissions');
    $groups = $query->result_array();

    //echo "<pre>"; print_r($groups); echo "</pre>"; exit();

    $result = array();
    foreach($groups as $group) {
      $result[] = $group['group_id'];
    }

    return $result;
  }

  /**
   * Get Permissions
   */
  function get_permissions() {
    $query = $this->auth->get('permissions');
    return $query->result_array();
  }

  /**
   * Get controllers
   */
  function get_controllers() {
    $query = $this->auth->get('controller');
    return $query->result_array();
  }

  /**
   * Change Permissions
   */
  function change_permissions($info) {
    $new_permissions = array();
    // Add New Permissions
    foreach($info as $key => $value) {
      if(preg_match('/^p_(\d+)_(\d+)$/',$key,$matches)) {
        $ctrl_id = $matches[1];
        $group_id = $matches[2];

        $new_permissions[] = array(
          'ctrl_id' => $ctrl_id,
          'group_id' => $group_id
        );

        $this->auth->where('ctrl_id',$ctrl_id);
        $this->auth->where('group_id',$group_id);
        $query = $this->auth->get('permissions');

        if($query->num_rows() == 0) {
          $this->auth->set('ctrl_id',$ctrl_id);
          $this->auth->set('group_id',$group_id);
          $this->auth->insert('permissions');
        }
      }
    }

    // Remove Old Permissions
    $old_permissions = $this->get_permissions();
    foreach($old_permissions as $old) {
      $check = FALSE;

      foreach($new_permissions as $new) {
        if($old['ctrl_id'] == $new['ctrl_id'] && $old['group_id'] == $new['group_id']) {
          $check = TRUE;
        }
      }

      if(!$check) {
        //delete permission
        $this->auth->where('permission_id',$old['permission_id']);
        $this->auth->delete('permissions');
      }
    }
    return TRUE;
  }
}
