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
        redirect('admin/permissions');
      }
      else {
        $this->session->set_flashdata('error','<div class="error">Permissions have not been changed.</div>');
        redirect('admin/permissions');
      }
    }

    $data['groups'] = $groups;
    $data['controllers'] = $controllers;
    $data['permissions'] = $permissions;

    $data['title'] = 'Manage Permissions';
    $data['id'] = 'admin';
    $this->template->load('templates/site','dev/permissions',$data);
  }
  
  /**
   * Display All Users for Management
   */
  public function users() {

    $users = $this->Auth_model->get_users();
    $data['users'] = $users;
    $data['id'] = 'admin';
    $data['title'] = 'Manage Users';
    $this->template->load('templates/site','admin/users',$data);
  }

  /**
   * Deactivate a User
   */
  public function deactivate($user_id) {
    
    $check = $this->Auth_model->deactivate_user((int)$user_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">User was deactivated</div>');
      redirect('admin/users');
    }
    else {
      $this->session->set_flashdata('error','<div class="error">User was not deactivated.</div>');
      redirect('admin/users');
    }
  }

  /**
   * Deactivate a User
   */
  public function activate($user_id) {
    
    $check = $this->Auth_model->activate_user((int)$user_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">User was activated</div>');
      redirect('admin/users');
    }
    else {
      $this->session->set_flashdata('error','<div class="error">User was not activated.</div>');
      redirect('admin/users');
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
      $this->form_validation->set_rules('address', 'Address', 'trim');
      $this->form_validation->set_rules('city', 'City', 'trim');
      $this->form_validation->set_rules('state', 'State', 'max_length[2]|min_length[2]');
      $this->form_validation->set_rules('zip', 'Zip', 'min_length[5]|max_length[10]|valid_zip');
      $this->form_validation->set_rules('phone', 'Phone Number', 'required|min_length[10]|max_length[14]|valid_phone');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run()) {
        $posts = $this->input->post();
        $check = $this->Auth_model->edit_user($posts);

        if($check) {
          $this->session->set_flashdata('success','<div class="success">User info was changed</div>');
          redirect('admin/users');
        }
        else {
          $this->session->set_flashdata('error','<div class="error">User info was not changed.</div>');
          redirect('admin/users');
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
          redirect('admin/users');
        }
        else {
          $this->session->set_flashdata('error','<div class="error">User info was not changed.</div>');
          redirect('admin/users');
        }
      }
    }
    $this->load->helper('general');
    $data['states'] = states_dropdown();
    $data['user'] = $user;
    $data['title'] = 'Edit User';
    $data['id'] = 'admin';
    $this->template->load('templates/site','admin/edit_user',$data);
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
    $data['id'] = 'admin';
    $this->template->load('templates/site','admin/user_groups',$data);
  }

  /**
   * Remove Group from user
   */
  public function remove_group($user_id, $group_id) {
    
    $check = $this->Auth_model->remove_group($user_id,$group_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">Group was successfully removed from user.</div>');
      redirect('admin/users_group/'.$user_id);
    }
    else {
      $this->session->set_flashdata('error','<div class="error">Group was not removed from user.</div>');
      redirect('admin/users_group/'.$user_id);
    }
  }

  /**
   * Add Group to user
   */
  public function add_group($user_id, $group_id) {
    
    $check = $this->Auth_model->set_group($user_id,$group_id);

    if($check) {
      $this->session->set_flashdata('success','<div class="success">Group was successfully added to user.</div>');
      redirect('admin/users_group/'.$user_id);
    }
    else {
      $this->session->set_flashdata('error','<div class="error">Group was not added to user.</div>');
      redirect('admin/users_group/'.$user_id);
    }
  }
  
  /**
   * Add New User
   */
  public function new_user() {
    if($this->input->post('new_user')) {
  
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('first_name', 'First Name', 'required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      $this->form_validation->set_rules('address', 'Address', 'trim');
      $this->form_validation->set_rules('city', 'City', 'trim');
      $this->form_validation->set_rules('state', 'State', 'max_length[2]|min_length[2]');
      $this->form_validation->set_rules('zip', 'Zip', 'min_length[5]|max_length[10]|valid_zip');
      $this->form_validation->set_rules('phone', 'Phone Number', 'required|min_length[10]|max_length[14]|valid_phone');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');
  
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
  
      if ($this->form_validation->run()) {
        $posts = $this->input->post();
        $check = $this->Auth_model->new_user($posts);
  
        if($check) {
          $this->session->set_flashdata('success','<div class="success">User was successfully added</div>');
          redirect('admin/users');
        }
        else {
          $this->session->set_flashdata('error','<div class="error">User was not added.</div>');
          redirect('admin/users');
        }
      }
    }
  
    
    $this->load->helper('general');
    $data['states'] = states_dropdown();
    $data['title'] = 'New User';
    $data['id'] = 'admin';
    $this->template->load('templates/site','admin/new_user',$data);
  }
   
  /**
   * Create New Group
   */
  public function new_group() {
      
  }
  
  /**
   * Create New Controller
   */
  public function new_conroller() {
      
  }
  
  /**
   * Add a New Page
   */
  public function new_page() {
    
  }
  
  /**
   * Edit a Page
   */
  public function edit_page($page_id) {
    
  }
  
  /**
   * Remove a Page
   */
  public function remove_page($page_id) {
    
  }
  
  /**
   * Add a New Gallery
   */
  public function new_gallery() {
    
  }
  
  /**
   * Edit a Gallery
   */
  public function edit_gallery($gallery_id) {
    
  }
  
  /**
   * Upload Images
   */
  public function upload_images() {
    
  }
  
  /**
   * Remove an Image
   */
  public function remove_image($image_id) {
    
  }
  
  /**
   * Edit an Image
   */
  public function edit_image($image_id) {
    
  }
  
  /**
   * Remove a Tag
   */
  public function remove_tag($tag_id) {
    
  }
  
  /**
   * Edit a Tag
   */
  public function edit_tag($tag_id) {
    
  }
    
}
