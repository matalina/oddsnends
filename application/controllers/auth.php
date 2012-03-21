<?php
/**
 * Auth Controller
 * @package Inventory Control
 * @author Alicia Wilkerson
 * @version 0.1.0
 */

/**
 * @package Inventory Control
 * @subpackage Controllers
 */
class Auth extends CI_Controller {
  /**
   * Initialize Controller
   * @access public
   */
  public function __construct() {
    parent::__construct();
    $this->load->model('Auth_model');
  }
  
  /**
   * Redirect to Login page
   * @access public
   */
  public function index() {
    $this->login();
  }
  
  /**
   * Login User
   * @access public
   */
  public function login() {
    if($this->session->userdata('user_id') && $this->session->userdata('username')) {
      if(!$this->session->userdata('groups')) {
        redirect('site/pending');
      }
      redirect('site/homepage');
    }
    $data = array();
    if($this->input->post('login')) {
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run()) {
        $user_id = $this->Auth_model->login($this->input->post('username'),$this->input->post('password'));
        if($user_id) {
          $this->session->set_userdata('user_id',$user_id);
          $this->session->set_userdata('username',$this->input->post('username'));
          $groups = implode(',',$this->Auth_model->get_user_groups($user_id));
          $this->session->set_userdata('groups',$groups);
          redirect('site/homepage');
        }
        else {
          $data['error'] = '<div class="error">Username/Password not found<br/>OR</br>Your Acccount is not Active</div>';
        }
      }
    }
    $this->template->set('title','Login');
    $this->template->load('templates/site','templates/auth/login',$data);
  }

  /**
   * Register New User (Not Needed)
   * @access protected
   */
  protected function _register() {
    if($this->session->userdata('user_id') && $this->session->userdata('username')) {
      if(!$this->session->userdata('groups')) {
        redirect('site/pending');
      }
      redirect('site/homepage');
    }
    $data = array();
    if($this->input->post('register')) {
      $this->form_validation->set_rules('username', 'Username', 'required|is_unqiue[users.username]');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
      $this->form_validation->set_rules('first_name', 'First Name', 'required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run()) {
        $this->load->model('Auth_model');
        $user_info['username'] = $this->input->post('username');
        $user_info['password'] = $this->input->post('password');
        $user_info['email'] = $this->input->post('email');
        $user_info['first_name'] = $this->input->post('first_name');
        $user_info['last_name'] = $this->input->post('last_name');
        $code = $this->Auth_model->register($user_info);

        $config = array(
          'protocol' => 'sendmail',
          'mailtype' => 'html'
        );

        $auth_email = $this->config->item('auth_email');

        $this->load->library('email',$config);
        $this->email->from($auth_email, 'Registration Email');
        $this->email->to(trim($this->input->post('email')),$this->input->post('first_name').' '.$this->input->post('last_name'));

        $this->email->subject('Registration Email');
        $this->email->message('<h1>Activiate your account</h1><p><strong>Username:</strong> '.$this->input->post('username').'<br/><strong>Password:</strong> '.$this->input->post('password').'</p><p>You must activate your account before you can log in.</p><p>'.anchor('auth/activate/'.$code,'Activate Your Account').'</p><p>This code expires in one day.</p>');
        $check = $this->email->send();

        $this->template->set('title','Account Created');
        if($check) {
          $data['message'] = '<div class="success">Your account has been created, you must activate it before you can log in.  You should receive an email with a link to activate your account.</div>';
        }
        else {
          $data['message'] = '<div class="error">Your account has been created, but the activation email was not sent.  Please Contact our web developer for assistance.</div>';
        }
        $this->template->load('templates/site','templates/message',$data);

        return;
      }
    }

    $this->template->set('title','Register');
    $this->template->load('templates/site','templates/auth/register',$data);
  }

  /**
   * Retreive Password
   * @access public
   */
  public function lost_password($code = '') {
    // If Lost Password form has been submitted
    if($this->input->post('lost_password')) {
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__email_exists');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        // Display email form
        $this->template->set('title','Lost Password');
        $this->template->load('templates/site','templates/auth/lost_password');
      }
      else {
        $code = $this->Auth_model->lost_password($this->input->post('email'));

        if($code != FALSE) {
          // Send Email
          $config = array(
            'protocol' => 'sendmail',
            'mailtype' => 'html'
          );

          $auth_email = $this->config->item('auth_email');

          $this->load->library('email',$config);
          $this->email->from($auth_email, 'Lost Password Email');
          $this->email->to(trim($this->input->post('email')));

          $this->email->subject('Lost Password Email');
          $this->email->message('<h1>Reset Your Password</h1><p>You have requested to reset your password.</p><p>'.anchor('auth/lost_password/'.$code,'Reset Password').'</p><p>This code expires in one day.</p>');
          $check = $this->email->send();

          // Display Message
          $this->template->set('title','Lost Password');
          if($check) {
            $data['message'] = '<div class="success">An email has been sent for you to continue the reset password process.</div>';
          }
          else {
            $data['message'] = '<div class="error">The email did not send.  Please contact your web developer for assistance.</div>';
          }
        }
        else {
          $data['message'] = '<div class="error">That email does not exist.</div>';
        }
        $this->template->set('title','Lost Password');
        $this->template->load('templates/site','templates/message',$data);
      }
    }
    // If Reset Password form has been submitted
    else if($this->input->post('reset_password')) {
      // Reset Password
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('confirm', 'Confirm', 'required|matches[password]');
      $this->form_validation->set_rules('user_id', 'user_id', 'required|integer');

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $this->template->set('title','Reset Password');
        $data['user_id'] = $this->input->post('user_id');
        $this->template->load('templates/site','templates/auth/reset_password',$data);
      }
      else {
        $check = $this->Auth_model->reset_password($this->input->post('user_id'),$this->input->post('password'));

        // Display Message
        $this->template->set('title','Reset Password');
        if($check) {
          $data['message'] = '<div class="success">Your password has been reset.  You may '.anchor('auth/login','login').' in now.</div>';
        }
        else {
          $data['message'] = '<div class="error">Your password was not reset.  Please Contact our web developer for assistance.</div>';
        }
        $this->template->set('title','Reset Password');
        $this->template->load('templates/site','templates/message',$data);
      }
    }
    // If there is no code present in the url
    else if($code == '') {
      // Display email form
      $this->template->set('title','Lost Password');
      $this->template->load('templates/site','templates/auth/lost_password');
    }
    // If a code was present with in a url
    else {
      // Validate code
      $user_id = $this->Auth_model->verify_lost_password($code);

      if($user_id > 0) {
        // Display Reset Password Form
        $this->template->set('title','Reset Password');
        $data['user_id'] = $user_id;
        $this->template->load('templates/site','templates/auth/reset_password',$data);
      }
      else {
        $data['message'] = '<div class="error">The code to reset your password has expired.  '.anchor('auth/lost_password','Please try again').'</div>';
        $this->template->set('title','Reset Password');
        $this->template->load('templates/site','templates/message',$data);
      }

    }
  }

  /**
   * Activate Account (Not Needed)
   * @access protected
   */
  protected function _activate($code) {
    $check = $this->Auth_model->activate($code);
    if($check) {
      $this->session->set_flashdata('success','<div class="success">Your account has been activated you may login now.</div>');
    }
    else {
      $this->session->set_flashdata('error','<div class="error">Your account has not been activated.  Your code has expired.</div>');
    }
    redirect('auth/login');
  }

  /**
   * Log user out
   * @access public
   */
  public function logout() {
    $this->load->library('Auth_lib');
    $this->auth_lib->logout();
    $this->session->set_flashdata('success','<div class="success">You have successfully logged out.</div>');
    redirect('site/index');
  }

  /**
   * Check if Email exits
   * @access protected
   */
  protected function _email_exists($data) {
    return $this->Auth_model->email_exists($data);
  }
}
