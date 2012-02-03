<?php
  require_once('/usr/local/www/private/owa/owa_php.php');

  $owa = new owa_php();
  // Set the site id you want to track
  $owa->setSiteId('ce0f93d1ff7b7eadce16841ded759426');
  // Uncomment the next line to set your page title
  $owa->setPageTitle($title);
  // Set other page properties
  //$owa->setProperty('foo', 'bar');
  $owa->trackPageView();
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo $title; ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="<?php echo base_url('css/css.php');?>">
  <!-- end CSS-->

  <script src="<?php echo base_url('js/libs/modernizr-2.0.6.min.js');?>"></script>
</head>

<body <?php echo $body_id;?>>

  <div id="container">
    <header>

    </header>
    <div id="main">
      <h1><?php echo $title;?></h1>
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
