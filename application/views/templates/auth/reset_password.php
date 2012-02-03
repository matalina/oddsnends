<div id="auth">
<?php
  if(isset($error)) {
    echo $error;
  }
  echo form_open('auth/lost_password', array('id' => 'reset_password'));

  echo validation_errors();

  echo form_fieldset('Reset Password');

  echo form_label('Password','password');
  echo form_password('password',set_value('password'),'id="password"');
  echo '<br/>';
  echo form_label('Confirm Password','confirm');
  echo form_password('confirm',set_value('confirm'),'id="confirm"');
  echo '<br/>';
  echo form_hidden('user_id',$user_id);
  echo form_submit('reset_password','Reset Password');
  echo form_fieldset_close();
  echo form_close();

?>
</div>
