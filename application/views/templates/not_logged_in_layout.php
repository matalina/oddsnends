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

<body id="not_logged_in">

  <div id="container">
      <?php
        if($this->session->flashdata('error')) {
          echo $this->sessin->flasdata('error');
        }
        if($this->session->flashdata('warning')) {
          echo $this->sessin->flasdata('warning');
        }
        if($this->session->flashdata('success')) {
          echo $this->sessin->flasdata('success');
        }
        if($this->session->flashdata('message')) {
          echo $this->sessin->flasdata('message');
        }
      ?>
    <?php echo $contents; ?>
  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo base_url('js/libs/jquery-1.7.1.min.js');?>"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo base_url('js/js.php');?>"></script>
  <!-- end scripts-->


  <script> // Change UA-XXXXX-X to be your site's ID
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>


  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>
