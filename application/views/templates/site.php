<?php
  $header['title'] = $title;
  $header['body_id'] = 'id="'.$id.'"';
  $this->load->view('templates/header',$header);
?>
<!-- Two Column Layout Start-->
<aside id="sidebar">
  <?php $this->load->view('templates/main_menu'); ?>
</aside>

<section id="gallery">
  <?php
    if($this->session->flashdata('error')) {
      echo $this->session->flashdata('error');
    }
    if($this->session->flashdata('warning')) {
      echo $this->session->flashdata('warning');
    }
    if($this->session->flashdata('success')) {
      echo $this->session->flashdata('success');
    }
    if($this->session->flashdata('message')) {
      echo $this->session->flashdata('message');
    }
  ?>
  <article id="content">
    if(isset($contents)) {
      echo $content; 
    }
  </article>
</section>
<br class="clear"/>

<!-- Two Column Layout End -->
<?php
  $footer = array();
  $this->load->view('templates/footer',$footer);
?>
