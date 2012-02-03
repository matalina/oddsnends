<table>
  <thead>
    <tr>
      <th>UID</th>
      <th>Store</th>
      <th>Username</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($users as $user) {
        ?>
          <tr>
            <td><?php echo $user['user_id'];?></td>
            <td><?php echo $user['username'];?></td>
            <td><?php echo $user['last_name'];?></td>
            <td><?php echo $user['first_name'];?></td>
            <td>
              <?php
                if($user['user_id'] != 1) {
                  if($user['active'] == 1) {
                    echo anchor('maintenance/deactivate/'.$user['user_id'],'Deactivate', 'class="button"');
                  }
                  else {
                    echo ' '.anchor('maintenance/activate/'.$user['user_id'],'Activate', 'class="button"');
                  }
                  echo ' '.anchor('maintenance/edit_user/'.$user['user_id'],'Edit User', 'class="button"');
                  echo ' '.anchor('maintenance/users_group/'.$user['user_id'],'Edit User Groups', 'class="button"');
                }
                else {
                  echo 'N/A';
                }
              ?>
            </td>
          </tr>
        <?php
      }
    ?>
  </tbody>
</table>
