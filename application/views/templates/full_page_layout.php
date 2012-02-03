<?php
  $header['title'] = $title;
  $header['body_id'] = 'id="full_page"';
  $this->load->view('templates/header',$header);
?>
<!-- Full Pay Layout Start-->

<article>
  <?php echo $contents; ?>
</article>

<!-- Full Pay Layout End -->
<?php
  $footer = '';
  $this->load->view('templates/footer',$footer);
?>
