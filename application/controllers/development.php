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
class Development extends RA_Controller {
  /**
   * Initialize Controller
   * @access public
   */
  public function __construct() {
    parent::__construct('development');
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
}
