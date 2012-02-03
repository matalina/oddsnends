<div id="auth">
<?php
  if(isset($error)) {
    echo $error;
  }
  echo form_open('auth/login', array('id' => 'login'));

  echo validation_errors();

  echo form_fieldset('Login');

  echo form_label('Username','username','class="js"');
  echo form_input('username',set_value('username'),'id="username"');
  echo '<br/>';
  echo form_label('Password','password','class="js"');
  echo form_password('password',set_value('password'),'id="password"');
  echo '<br/>';
  echo form_submit('login','Login');
  echo form_fieldset_close();
  echo form_close();

  echo anchor('auth/register','Register New User');
  echo anchor('auth/lost_password','Lost Password?');
?>
</div>
