<?php
/**
 * Controller's Name
 * @package Project's Name
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Project's Name
 * @subpackage Controllers
 */
class Admin extends RA_Controller {
  /**
   * Initialize Controller
   * @access public
   */
  public function __construct() {
    parent::__construct('admin');
  }

  /**
   * Manage Permissions
   */
  public function permissions() {
    $controllers = $this->Auth_model->get_controllers();
    $groups = $this->Auth_model->get_groups();
    $permissions = $this->Auth_model->get_permissions();

    if($this->input->post('change_permissions')) {
      $posts = $this->input->post();
      $check = $this->Auth_model->change_permissions($posts);

      if($check) {
        $this->session->set_flashdata('success','<div class="success">Permissions have been changed.</div>');
        redirect('development/permissions');
      }
      else {
        $this->session->set_flashdata('error','<div class="error">Permissions have not been changed.</div>');
        redirect('development/permissions');
      }
    }

    $data['groups'] = $groups;
    $data['controllers'] = $controllers;
    $data['permissions'] = $permissions;

    $data['title'] = 'Manage Permissions';
    $this->template->load('templates/two_column_layout','dev/permissions',$data);
  }
  
  /**
   * Display All Users for Management
   */
  public function users() {

    $users = $this->Auth_model->get_users();
    $data['users'] = $users;

    $data['title'] = 'Manage Users';
    $this->template->load('templates/two_column_layout','maintenance/users',$data);
  }

  /**
   * Deactivate a User
   */
  public function deactivate($user_id) {
    
    $check = $this->Auth_model->deactivate_user((int)$user_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">User was deactivated</div>');
      redirect('maintenance/users');
    }
    else {
      $this->session->set_flashdata('error','<div class="error">User was not deactivated.</div>');
      redirect('maintenance/users');
    }
  }

  /**
   * Deactivate a User
   */
  public function activate($user_id) {
    
    $check = $this->Auth_model->activate_user((int)$user_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">User was activated</div>');
      redirect('maintenance/users');
    }
    else {
      $this->session->set_flashdata('error','<div class="error">User was not activated.</div>');
      redirect('maintenance/users');
    }
  }

  /**
   * Edit User
   */
  public function edit_user($user_id = '') {
    
    if($user_id != '') {
      $user = $this->Auth_model->get_user($user_id);
    }
    else {
      $user = $this->Auth_model->get_user($this->input->post('user_id'));
    }

    if($this->input->post('edit_user')) {

      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('first_name', 'First Name', 'required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      $this->form_validation->set_rules('store_id', 'Store/District', 'required');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run()) {
        $posts = $this->input->post();
        $check = $this->Auth_model->edit_user($posts);

        if($check) {
          $this->session->set_flashdata('success','<div class="success">User info was changed</div>');
          redirect('maintenance/users');
        }
        else {
          $this->session->set_flashdata('error','<div class="error">User info was not changed.</div>');
          redirect('maintenance/users');
        }
      }
    }

    if($this->input->post('change_password')) {
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run()) {
        $check = $this->Auth_model->reset_password($this->input->post('user_id'),$this->input->post('password'));

        if($check) {
          $this->session->set_flashdata('success','<div class="success">User info was changed</div>');
          redirect('maintenance/users');
        }
        else {
          $this->session->set_flashdata('error','<div class="error">User info was not changed.</div>');
          redirect('maintenance/users');
        }
      }
    }

    $this->load->model('Stores_model');
    $this->load->helper('general');
    $districts_dd = make_dropdown($this->Stores_model->get_districts(),'district_name','district_name');
    $stores_dd = make_dropdown($this->Stores_model->get_all_stores(),'STID','STID');
    $data['stores'] = array('Home Office' => array('999' => '999'),'Districts' => $districts_dd, 'Stores' => $stores_dd);
    $data['user'] = $user;
    $data['title'] = 'Edit User';
    $this->template->load('templates/two_column_layout','maintenance/edit_user',$data);
  }

  /**
   * Change User Groups
   */
  public function users_group($user_id) {
    
    $user = $this->Auth_model->get_user($user_id);
    $user_groups = $this->Auth_model->get_user_groups_more($user_id);
    $groups = $this->Auth_model->get_groups();

    $data['user'] = $user;
    $data['user_groups'] = $user_groups;
    $this->load->helper('general');
    $data['groups'] = $groups;
    $data['title'] = 'Edit User Groups';
    $this->template->load('templates/two_column_layout','maintenance/user_groups',$data);
  }

  /**
   * Remove Group from user
   */
  public function remove_group($user_id, $group_id) {
    
    $check = $this->Auth_model->remove_group($user_id,$group_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">Group was successfully removed from user.</div>');
      redirect('maintenance/users_group/'.$user_id);
    }
    else {
      $this->session->set_flashdata('error','<div class="error">Group was not removed from user.</div>');
      redirect('maintenance/users_group/'.$user_id);
    }
  }

  /**
   * Add Group to user
   */
  public function add_group($user_id, $group_id) {
    
    $check = $this->Auth_model->set_group($user_id,$group_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">Group was successfully added to user.</div>');
      redirect('maintenance/users_group/'.$user_id);
    }
    else {
      $this->session->set_flashdata('error','<div class="error">Group was not added to user.</div>');
      redirect('maintenance/users_group/'.$user_id);
    }
  }
  
  /**
   * Add New User
   */
   public function new_user() {
   
   }
}
