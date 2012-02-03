<?php
  $header['title'] = $title;
  $header['body_id'] = 'id="two_column"';
  $this->load->view('templates/header',$header);
?>
<!-- Two Column Layout Start-->

<article id="content">
  <?php echo $contents; ?>
</article>

<aside id="sidebar">
  <?php
    $this->load->view('templates/main_menu');
  ?>
</aside>
<br class="clear"/>
<!-- Two Column Layout End -->
<?php
  $footer = '';
  $this->load->view('templates/footer',$footer);
?>
