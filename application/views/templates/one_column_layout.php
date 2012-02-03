<?php
  $header['title'] = $title;
  $header['body_id'] = 'id="one_column"';
  $this->load->view('templates/header',$header);
?>
<!-- One Column Layout Start-->

<article>
  <?php echo $contents; ?>
<article>

<!-- One Column Layout End -->
<?php
  $footer = '';
  $this->load->view('templates/footer',$footer);
?>
