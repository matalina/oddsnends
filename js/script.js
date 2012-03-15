(function () {  
  var $j, $url, re, matches, $base_url,$img_url;
  $j = jQuery.noConflict();
  
  $url = window.location.href.toString();
  re = /^(http:\/\/\w*\.*(\w+\.\w+)\/.*)\/*index\.php*/;
  matches = re.exec($url);
  
  $base_url = matches[0];
  $img_url = matches[1];
  
  $j().ready(function() {
    $j('.js_reveal').show(); // show javascript areas
    $j('.js_remove').hide(); // remove areas that are needed for no javascript
    
    // remove messages after loading
    $j('.message').delay(10000).fadeOut('slow');
    $j('.error').delay(10000).fadeOut('slow');
    $j('.success').delay(10000).fadeOut('slow');
    $j('.warning').delay(10000).fadeOut('slow');
    
    // Content out of view
    var $content, $sidebar, width, position;
    $content = $j('#content');
    $sidebar = $j('#sidebar');
    width = $content.outerWidth(true) + 100;
    position = $content.position().left;
    $content.css('left', -width).prepend('<div id="close">X</div>').css('padding-top','25px');
    
    // Reveal Content on sidebar click 
    /**
     * Need to add load page from content click!
     */
    $j($sidebar).on('click','a',function () {
      var $this, my_position;
      $this = $j(this);
      $j($sidebar).find('.arrow').remove();
      $j($this).parent().append('<div class="arrow">&nbsp;</div>');
      my_position = $content.position().left;
      if(my_position == position) {
       $j('#content').animate({left: -width},700).delay(500).animate({left: 0},700);
      }
      else {
        $j($content).animate({left: 0},700);
      }  
      return false;
    });
    
    // Close Content Window
    $j('#close').on('click',function() {
        $j('#content').animate({left: -width},700);
        $j($sidebar).find('.arrow').remove();
    });
  
  });
})();  
