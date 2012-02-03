<?php
  echo form_open('maintenance/edit_user');
  echo form_hidden('user_id',$user['user_id']);
  echo form_fieldset('Edit User');

  echo form_label('Username');
  echo form_input('username',set_value('username',$user['username']));
  echo form_error('username');
  echo '<br/>';

  echo form_label('Email');
  echo form_input('email',set_value('email',$user['email']));
  echo form_error('email');
  echo '<br/>';

  echo form_label('First Name');
  echo form_input('first_name',set_value('first_name',$user['first_name']));
  echo form_error('first_name');
  echo '<br/>';

  echo form_label('Last Name');
  echo form_input('last_name',set_value('last_name',$user['last_name']));
  echo form_error('last_name');
  echo '<br/>';

  echo form_submit('edit_user','Edit User');
  echo form_fieldset_close();

  echo form_fieldset('Change Password');

  echo form_label('Password');
  echo form_password('password');
  echo form_error('password');
  echo '<br/>';
  echo form_label('Confirm Password');
  echo form_password('confirm');
  echo form_error('confirm');
  echo '<br/>';

  echo form_submit('change_password','Change Password');
  echo form_fieldset_close();
  echo form_close();
?>
