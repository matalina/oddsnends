<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['contact'] = 'site/contact';
$route['gallery/(:any)'] = 'site/gallery/$1';
$route['auth/(:any)'] = 'auth/$1';
$route['image/(:any)'] = 'image/$1';
$route['client/(:any)'] = 'client/$1';
$route['admin/(:any)'] = 'admin/$1';
$route['(([a-zA-Z]+)\.([a-zA-Z]+)\/*(\d+)*'] = 'client/gallery/$1/$2/$3';
$route['(:any)'] = 'site/page/$1';

$route['default_controller'] = "site";
$route['404_override'] = 'my404';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
