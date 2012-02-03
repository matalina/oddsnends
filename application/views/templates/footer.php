    </div> <!--! end #main -->
    <footer>

    </footer>
  </div> <!--! end of #container -->


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo base_url('js/libs/jquery-1.7.1.min.js');?>"><\/script>')</script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo base_url('js/js.php');?>"></script>

  <?php
    if(isset($GLOBALS['page_script'])) {
      echo $GLOBALS['page_script'];
    }
  ?>
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
