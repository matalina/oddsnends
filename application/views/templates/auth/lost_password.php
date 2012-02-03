<div id="auth">
<?php
  if(isset($error)) {
    echo $error;
  }
  echo form_open('auth/lost_password', array('id' => 'lost_password'));

  echo validation_errors();

  echo form_fieldset('Lost Password');

  echo form_label('Email','email','class="js"');
  echo form_input('email',set_value('email'),'id="email"');
  echo '<br/>';
  echo form_submit('lost_password','Lost Password');
  echo form_fieldset_close();
  echo form_close();

?>
</div>
