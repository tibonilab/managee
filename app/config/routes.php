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

$route['default_controller'] = "front/home";
$route['404_override'] = '';


$route['courtesy']				= 'courtesy';

/* auth */ 
$route['admin/users']           = 'auth/index';
$route['it/auth/create_user']	= 'auth/create_user';
$route['login']             = 'auth/login';
$route['logout']            = 'auth/logout';

/* pages */ 
$route['admin/contenuti/pagine/elimina/(:num)']   = 'admin/pages/delete/$1';
$route['admin/contenuti/pagine/modifica/(:num)']  = 'admin/pages/form/$1';
$route['admin/contenuti/pagine/inserisci']        = 'admin/pages/form';
$route['admin/contenuti/pagine']                  = 'admin/pages';

/* offers */ 
$route['admin/contenuti/offerte/elimina/(:num)']   = 'admin/offers/delete/$1';
$route['admin/contenuti/offerte/modifica/(:num)']  = 'admin/offers/form/$1';
$route['admin/contenuti/offerte/inserisci']        = 'admin/offers/form';
$route['admin/contenuti/offerte']                  = 'admin/offers';

/* professionals */ 
$route['admin/contenuti/team/elimina/(:num)']   = 'admin/professionals/delete/$1';
$route['admin/contenuti/team/modifica/(:num)']  = 'admin/professionals/form/$1';
$route['admin/contenuti/team/inserisci']        = 'admin/professionals/form';
$route['admin/contenuti/team']                  = 'admin/professionals';


/* partners */ 
$route['admin/contenuti/partners/elimina/(:num)']   = 'admin/partners/delete/$1';
$route['admin/contenuti/partners/modifica/(:num)']  = 'admin/partners/form/$1';
$route['admin/contenuti/partners/inserisci']        = 'admin/partners/form';
$route['admin/contenuti/partners']                  = 'admin/partners';


/* news */ 
$route['admin/contenuti/news/elimina/(:num)']   = 'admin/news/delete/$1';
$route['admin/contenuti/news/modifica/(:num)']  = 'admin/news/form/$1';
$route['admin/contenuti/news/inserisci']        = 'admin/news/form';
$route['admin/contenuti/news']                  = 'admin/news';

/* features */
$route['admin/prodotti/caratteristiche/elimina/(:num)']  = 'admin/features/delete/$1';
$route['admin/prodotti/caratteristiche/modifica/(:num)'] = 'admin/features/form/$1';
$route['admin/prodotti/caratteristiche/inserisci']       = 'admin/features/form';
$route['admin/prodotti/caratteristiche/oops']          = 'admin/features/error';
$route['admin/prodotti/caratteristiche']                 = 'admin/features';

/* groups */
$route['admin/prodotti/gruppi-caratteristiche/elimina/(:num)']  = 'admin/groups_features/delete/$1';
$route['admin/prodotti/gruppi-caratteristiche/modifica/(:num)'] = 'admin/groups_features/form/$1';
$route['admin/prodotti/gruppi-caratteristiche/inserisci']       = 'admin/groups_features/form';
$route['admin/prodotti/gruppi-caratteristiche']                 = 'admin/groups_features';

/* types */
$route['admin/prodotti/tipologie/elimina/(:num)']  = 'admin/types/delete/$1';
$route['admin/prodotti/tipologie/modifica/(:num)'] = 'admin/types/form/$1';
$route['admin/prodotti/tipologie/inserisci']       = 'admin/types/form';
$route['admin/prodotti/tipologie']                 = 'admin/types';

/* products */
$route['admin/luoghi/inventario/(:num)/elimina/(:num)']	= 'admin/products/delete/$2/$1';
$route['admin/luoghi/inventario/(:num)/modifica/(:num)']	= 'admin/products/form/$2/$1';
$route['admin/luoghi/inventario/elimina/(:num)']			= 'admin/products/delete/$1';
$route['admin/luoghi/inventario/modifica/(:num)']			= 'admin/products/form/$1';
$route['admin/luoghi/inventario/(:num)/inserisci']		= 'admin/products/form';
$route['admin/luoghi/inventario/inserisci']				= 'admin/products/form';
$route['admin/luoghi/inventario/(:num)']					= 'admin/products/index/$1';
$route['admin/luoghi/inventario']							= 'admin/products';


/* versions */
$route['admin/luoghi/inventario/modifica-versione/(:num)/(:num)']	= 'admin/versions/form/$1/$2';
$route['admin/luoghi/inventario/aggiungi-versione/(:num)']		= 'admin/versions/form/$1';


/* product categories */ 
$route['admin/luoghi/categorie/elimina/(:num)']   = 'admin/product_categories/delete/$1';
$route['admin/luoghi/categorie/modifica/(:num)']  = 'admin/product_categories/form/$1';
$route['admin/luoghi/categorie/inserisci']        = 'admin/product_categories/form';
$route['admin/luoghi/categorie']                  = 'admin/product_categories';


$route['admin/contenuti/pagine/categorie/elimina/(:num)']   = 'admin/categories/delete/pages/$1';
$route['admin/contenuti/pagine/categorie/modifica/(:num)']  = 'admin/categories/form/pages/$1';
$route['admin/contenuti/pagine/categorie/inserisci']        = 'admin/categories/form/pages';
$route['admin/contenuti/pagine/categorie']                  = 'admin/categories/index/pages';



/* properties */
$route['admin/prodotti/proprieta/elimina/(:num)']  = 'admin/properties/delete/$1';
$route['admin/prodotti/proprieta/modifica/(:num)'] = 'admin/properties/form/$1';
$route['admin/prodotti/proprieta/inserisci']       = 'admin/properties/form';
$route['admin/prodotti/proprieta']                 = 'admin/properties';



/* links */
$route['admin/prodotti/links/elimina/(:num)']  = 'admin/links/delete/$1';
$route['admin/prodotti/links/modifica/(:num)'] = 'admin/links/form/$1';
$route['admin/prodotti/links/inserisci']       = 'admin/links/form';
$route['admin/prodotti/links']                 = 'admin/links';


$route['admin/posizione']						= 'admin/tools/geolocalization';



$route['admin/ordini']                  = 'admin/orders';
$route['admin/clienti']                 = 'admin/customers';


/* showcases */
$route['admin/contenuti/gallerie/elimina/(:num)']			= 'admin/showcases/delete/$1';
$route['admin/contenuti/gallerie/modifica-lista/(:num)']		= 'admin/showcases/form_featured/$1';
$route['admin/contenuti/gallerie/inserisci-lista']			= 'admin/showcases/form_featured';
$route['admin/contenuti/gallerie/modifica/(:num)']			= 'admin/showcases/form/$1';
$route['admin/contenuti/gallerie/inserisci']					= 'admin/showcases/form';
$route['admin/contenuti/gallerie']							= 'admin/showcases';


/* texts */
$route['admin/contenuti/testi/elimina/(:num)']		= 'admin/texts_manager/delete/$1';
$route['admin/contenuti/testi/modifica/(:num)']		= 'admin/texts_manager/form/$1';
$route['admin/contenuti/testi/inserisci']			= 'admin/texts_manager/form';
$route['admin/contenuti/testi']						= 'admin/texts_manager';


$route['admin/articoli']                = 'admin/articles';
$route['admin/categorie-articoli']      = 'admin/article_categories';
$route['admin/gallerie-multimediali']   = 'admin/mediagalleries';

/* images */ 
$route['admin/multimedia/immagini/elimina/(:num)']  = 'admin/images/delete/$1';
$route['admin/multimedia/immagini/modifica/(:num)'] = 'admin/images/form/$1';
$route['admin/multimedia/immagini/inserisci']       = 'admin/images/form';
$route['admin/multimedia/immagini']                 = 'admin/images';


$route['admin/multimedia/video/elimina/(:num)']		= 'admin/videos/delete/$1';
$route['admin/multimedia/video/modifica/(:num)']		= 'admin/videos/form/$1';
$route['admin/multimedia/video/inserisci']			= 'admin/videos/form';
$route['admin/multimedia/video']						= 'admin/videos';


$route['admin/contenuti/menu/elimina/(:num)']							= 'admin/menus/delete/$1';
$route['admin/contenuti/menu/modifica/(:num)']							= 'admin/menus/form/$1';
$route['admin/contenuti/menu/inserisci']								= 'admin/menus/form';
$route['admin/contenuti/menu/voce-di-menu/(:num)/(:num)']				= 'admin/menus/menu_item_form/$1/$2';
$route['admin/contenuti/menu/voce-di-menu/(:num)']						= 'admin/menus/menu_item_form/$1';
$route['admin/contenuti/menu']											= 'admin/menus';

$route['admin/allegati']                = 'admin/attachments';



/* dashboards */ 
$route['admin/prodotti']    = 'admin/dashboard/products';
$route['admin/contenuti']   = 'admin/dashboard/contents';
$route['admin/multimedia']  = 'admin/dashboard/media';



$route['ajax/email']				= 'ajax/email';

$route['admin']						= 'auth/login';



/**
 * 
 * FRONT END
 * 
 */

$route['^([a-z]{2})$']              = $route['default_controller'];

$route['^([a-z]{2})/sitemap.xml']   = 'sitemap/index';


$route['^([a-z]{2})/ajax/email']  = 'ajax/email';

/* video */
$route['^([a-z]{2})/video']  = 'front/videos';
$route['video']  = 'front/videos';



/* photo */
$route['^([a-z]{2})/photo']  = 'front/categories';


/* blog */
$route['^([a-z]{2})/blog']  = 'front/blog';


/* news */
$route['^([a-z]{2})/news']					= 'front/news';
$route['news']								= 'front/news';

/* professionals */
$route['^([a-z]{2})/team']					= 'front/professionals';


$route['^([a-z]{2})/offerte']					= 'front/offers';
/*
$route['^([a-z]{2})/offres']					= 'front/news';
$route['^([a-z]{2})/offers']					= 'front/news';
$route['^([a-z]{2})/angebote']					= 'front/news';
 */



$route['^([a-z]{2})/test_pages']					= 'front/pages/test';

$route['^([a-z]{2})/contatti']					= 'front/pages/contacts';
$route['^([a-z]{2})/contacts']					= 'front/pages/contacts';
$route['^([a-z]{2})/contacts']					= 'front/pages/contacts';
$route['^([a-z]{2})/kontakte']					= 'front/pages/contacts';




/* pdf output */
$route['^([a-z]{2})/pdf-product/(:num)'] = 'front/products/bom/$2';
$route['^([a-z]{2})/pdf-version/(:num)'] = 'front/versions/bom/$2';


/* test pages */
$route['^([a-z]{2})/pages/test/(:any)']  = 'front/pages/test/$2';

/* custom pages*/
//$route['^([a-z]{2})/(:any)']  = 'front/home';



/* End of file routes.php */
/* Location: ./application/config/routes.php */