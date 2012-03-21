<p><?php
  echo anchor('admin/new_group','Add New Group');
  echo ' | ';
  echo anchor('admin/new_controller','Add New Controller');
?></p>
<?php
  echo form_open('admin/permissions');
?>
<table>
  <thead>
    <tr>
      <th>Groups &rarr;<br/>
        &darr; Controllers</th>
      <?php
        foreach($groups as $group) {
          ?>
            <th><?php echo $group['name'];?></th>
          <?php
        }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
      $count = count($groups);
      foreach($controllers as $ctrl) {
        ?>
          <tr>
            <th><?php echo $ctrl['ctrl_uri'];?></th>
            <?php
              $ctrl_id = $ctrl['ctrl_id'];
              for($i = 1; $i < ($count + 1); $i++) {
                $default = false;
                foreach($permissions as $perm) {
                  if($perm['ctrl_id'] == $ctrl_id && $perm['group_id'] == $i) {
                    $default = true;
                  }
                }
                ?>
                  <td>
                    <?php echo form_checkbox('p_'.$ctrl_id.'_'.$i,set_value('p_'.$ctrl_id.'_'.$i),$default);?>
                  </td>
                <?php
              }
            ?>
          </tr>
        <?php
      }
    ?>
  </tbody>
</table>
<?php
  echo form_submit('change_permissions','Change Permissions');
  echo form_close();
?>
