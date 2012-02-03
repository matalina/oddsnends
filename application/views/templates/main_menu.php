<nav id="menu">
  <ul>
    <?php
      // All Users Allowed to see these menu items
      if($this->auth_lib->is_allowed('member')) {
        ?>
          <li>Welcome back, <?php echo $this->session->userdata('username');?>!</li>
          <li><div class="heading">Corporate</div>
            <ul>
              <li><?php echo anchor('site/homepage','Home');?></li>
              <li><?php echo anchor('auth/logout','Logout');?></li>
            </ul>
          </li>
        <?php
      }

      // Super Admin users only
      if($this->auth_lib->is_allowed('maintenance')) {
        ?>
          <li><div class="heading">Maintenance</div>
            <ul>
              <li><?php echo anchor('maintenance/users','Manage Users');?></li>
            </ul>
          </li>
        <?php
      }

      // Developer users only
      if($this->auth_lib->is_allowed('development')) {
        ?>
          <li><div class="heading">Development</div>
            <ul>
              <li><?php echo anchor('development/permissions','Manage Permissions');?></li>
            </ul>
          </li>
        <?php
      }

    ?>
  </ul>
</nav>
