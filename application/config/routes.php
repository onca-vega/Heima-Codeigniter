<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';

$baseRoute = "api";

$route[$baseRoute] = 'api/Info_Controller/info';
$route[$baseRoute.'/token'] = 'api/Token_Controller/token';
$route[$baseRoute.'/cliente'] = 'cliente/Cliente_Controller/clientes';
$route[$baseRoute.'/cliente/(:num)'] = 'cliente/Cliente_Controller/cliente/$1';

$route[$baseRoute.'/cliente/(:num)/empresa'] = 'cliente/Cliente_Empresa_Controller/cliente_empresas/$1';
$route[$baseRoute.'/cliente/(:num)/empresa/(:num)'] = 'cliente/Cliente_Empresa_Controller/cliente_empresa/$1/$2';

$route[$baseRoute.'/cliente/(:num)/empresa/(:num)/proyecto'] = 'cliente/Cliente_Empresa_Proyecto_Controller/cliente_empresa_proyectos/$1/$2';
$route[$baseRoute.'/cliente/(:num)/empresa/(:num)/proyecto/(:num)'] = 'cliente/Cliente_Empresa_Proyecto_Controller/cliente_empresa_proyecto/$1/$2/$3';


$route[$baseRoute.'/empresa'] = 'empresa/Empresa_Controller/empresas';
$route[$baseRoute.'/empresa/(:num)'] = 'empresa/Empresa_Controller/empresa/$1';

$route[$baseRoute.'/empresa/(:num)/cliente'] = 'empresa/Empresa_Cliente_Controller/empresa_clientes/$1';
$route[$baseRoute.'/empresa/(:num)/cliente/(:num)'] = 'empresa/Empresa_Cliente_Controller/empresa_cliente/$1/$2';

$route[$baseRoute.'/empresa/(:num)/cliente/(:num)/proyecto'] = 'empresa/Empresa_Cliente_Proyecto_Controller/empresa_cliente_proyectos/$1/$2';
$route[$baseRoute.'/empresa/(:num)/cliente/(:num)/proyecto/(:num)'] = 'empresa/Empresa_Cliente_Proyecto_Controller/empresa_cliente_proyecto/$1/$2/$3';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
