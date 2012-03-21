<h2><?php echo $user['username'];?></h2>
<p>Email: <?php echo $user['email'];?><br/>
  Name: <?php echo $user['first_name'].' '.$user['last_name'];?></p>

<h3>Current Groups</h3>
<ul>
<?php
  if(!empty($user_groups)) {
    foreach($user_groups as $ug) {
      ?>
        <li><?php echo $ug['name'].' - '.anchor('admin/remove_group/'.$ug['user_id'].'/'.$ug['group_id'],'Remove Group');?></li>
      <?php
    }
  }
  else {
    ?>
      <li>This user is not associated with any groups.</li>
    <?php
  }
?>
</ul>

<h3>Add New Group</h3>
<ul>
<?php
  foreach($groups as $group) {
    $check = TRUE;
    foreach ($user_groups as $ug) {
      if($group['id'] == $ug['group_id']) {
        $check = FALSE;
      }
    }
    if($check) {
      echo '<li>'.$group['name'].' - '.anchor('admin/add_group/'.$user['user_id'].'/'.$group['id'],'Add Group to User').'</li>';
    }
  }
?>
</ul>
