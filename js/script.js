
$j = jQuery.noConflict();

$url = window.location.href.toString();
re = /^(http:\/\/\w*\.*(\w+\.\w+)\/.*)\/*index\.php*/;
matches = re.exec($url)

var $base_url = matches[0];
var $img_url = matches[1];

$j().ready(function() {
  $j('.js_reveal').show(); // show javascript areas
  $j('.js_remove').hide(); // remove areas that are needed for no javascript

});
