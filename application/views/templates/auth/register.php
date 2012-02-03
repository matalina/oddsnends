<div id="auth">
<?php
  if(isset($error)) {
    echo $error;
  }
  echo form_open('auth/register', array('id' => 'register'));

  echo validation_errors();

  echo form_fieldset('Register');

  echo form_label('Username','username');
  echo form_input('username',set_value('username'),'id="username"');
  echo '<br/>';
  echo form_label('Email','email');
  echo form_input('email',set_value('email'),'id="email"');
  echo '<br/>';
  echo form_label('First Name','first_name');
  echo form_input('first_name',set_value('first_name'),'id="first_name"');
  echo '<br/>';
  echo form_label('Last Name','last_name');
  echo form_input('last_name',set_value('last_name'),'id="email"');
  echo '<br/>';
  echo form_label('Password','password');
  echo form_password('password',set_value('password'),'id="password"');
  echo '<br/>';
  echo form_label('Confirm Password','confirm');
  echo form_password('confirm',set_value('confirm'),'id="confirm"');
  echo '<br/>';
  echo form_submit('register','Register');
  echo form_fieldset_close();
  echo form_close();

?>
</div>
