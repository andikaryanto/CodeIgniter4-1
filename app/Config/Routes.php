<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override("App\Controllers\Error::pagenotfound");
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// routes since we don't have to scan directories.
$routes->get('/', 'Welcome::index');
$routes->get('/home', 'Home::index');
$routes->get('/report', 'Report::index');
$routes->get('/changeLanguage', 'M_user::changelanguage');

$routes->get('/Forbidden', 'Error::forbidden');

$parent='/welcome';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'Welcome::index');
});
$routes->get('filter', 'Welcome::filter');

$parent='/login';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'Login::index');
});
$routes->post('dologin', 'Login::dologin');
$routes->get('dologout', 'Login::dologout');


$parent='/reports';
$routes->group('/reports', function ($routes) {
    $routes->get('/', 'Report::index');
});
$routes->get('getAllData', 'Report::getAllData');

$parent='/mgroupuser';
$routes->group($parent, function ($routes) {
    $routes->get('', 'M_groupuser::index');
    $routes->get('add', 'M_groupuser::add');
    $routes->post('addsave', 'M_groupuser::addsave');
    $routes->get('edit/(:num)', 'M_groupuser::edit/$1');
    $routes->post('editsave', 'M_groupuser::editsave');
    $routes->post('delete', 'M_groupuser::delete');
    $routes->get('editrole/(:num)', 'M_groupuser::editrole/$1');
    $routes->post('saverole', 'M_groupuser::saverole');
    $routes->post('savereportrole', 'M_groupuser::savereportrole');
    $routes->get('editreportrole/(:num)', 'M_groupuser::editreportrole');
    $routes->get('getAllData', 'M_groupuser::getAllData');
    $routes->get('getDataModal', 'M_groupuser::getDataModal');
});


$parent='/muser';
$routes->group($parent, function ($routes) {
    $routes->get('', 'M_user::index');
    $routes->get('add', 'M_user::add');
    $routes->post('addsave', 'M_user::addsave');
    $routes->get('edit/(:num)', 'M_user::edit/$1');
    $routes->post('editsave', 'M_user::editsave');
    $routes->post('delete', 'M_user::delete');
    $routes->get('getAllData', 'M_user::getAllData');
});

$routes->group('/muserlocation', function ($routes) {
    $routes->get('/', 'M_userlocation::index');
});

$parent='/mprovince';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_province::index');
    $routes->get('add', 'M_province::add');
    $routes->post('addsave', 'M_province::addsave');
    $routes->get('edit/(:num)', 'M_province::edit/$1');
    $routes->post('editsave', 'M_province::editsave');
    $routes->post('delete', 'M_province::delete');
    $routes->get('getAllData', 'M_province::getAllData');
    $routes->get('getDataModal', 'M_province::getDataModal');
});

$parent='/mcompany';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_company::add');
});
$routes->post('addsave', 'M_company::addsave');

$parent='/mdistrict';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_district::index');
    $routes->get('add', 'M_district::add');
    $routes->post('addsave', 'M_district::addsave');
    $routes->get('edit/(:num)', 'M_district::edit/$1');
    $routes->post('editsave', 'M_district::editsave');
    $routes->post('delete', 'M_district::delete');
    $routes->get('getAllData', 'M_district::getAllData');
    $routes->get('getDataModal', 'M_district::getDataModal');
    
});
$parent='/msubdistrict';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_subdistrict::index');
    $routes->get('add', 'M_subdistrict::add');
    $routes->post('addsave', 'M_subdistrict::addsave');
    $routes->get('edit/(:num)', 'M_subdistrict::edit/$1');
    $routes->post('editsave', 'M_subdistrict::editsave');
    $routes->post('delete', 'M_subdistrict::delete');
    $routes->get('getAllData', 'M_subdistrict::getAllData');
    $routes->get('getDataModal', 'M_subdistrict::getDataModal');
});

$parent='/mvillage';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_village::index');
    $routes->get('add', 'M_village::add');
    $routes->post('addsave', 'M_village::addsave');
    $routes->get('edit/(:num)', 'M_village::edit/$1');
    $routes->post('editsave', 'M_village::editsave');
    $routes->post('delete', 'M_village::delete');
    $routes->get('getAllData', 'M_village::getAllData');
    $routes->get('getDataModal', 'M_village::getDataModal');
});

$parent='/msubvillage';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_subvillage::index');
    $routes->get('add', 'M_subvillage::add');
    $routes->post('addsave', 'M_subvillage::addsave');
    $routes->get('edit/(:num)', 'M_subvillage::edit/$1');
    $routes->post('editsave', 'M_subvillage::editsave');
    $routes->post('delete', 'M_subvillage::delete');
    $routes->get('getAllData', 'M_subvillage::getAllData');
    $routes->get('getDataModal', 'M_subvillage::getDataModal');
});

$parent='/mdisaster';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_disaster::index');
    $routes->get('add', 'M_disaster::add');
    $routes->post('addsave', 'M_disaster::addsave');
    $routes->get('edit/(:num)', 'M_disaster::edit/$1');
    $routes->post('editsave', 'M_disaster::editsave');
    $routes->post('delete', 'M_disaster::delete');
    $routes->get('getAllData', 'M_disaster::getAllData');
    $routes->get('getDataModal', 'M_disaster::getDataModal');
    
});
$parent='/minfrastructurecategory';
$routes->group('/minfrastructurecategory', function ($routes) {
    $routes->get('/', 'M_infrastructurecategory::index');
    $routes->get('add', 'M_infrastructurecategory::add');
    $routes->post('addsave', 'M_infrastructurecategory::addsave');
    $routes->get('edit/(:num)', 'M_infrastructurecategory::edit/$1');
    $routes->post('editsave', 'M_infrastructurecategory::editsave');
    $routes->post('delete', 'M_infrastructurecategory::delete');
    $routes->get('getAllData', 'M_infrastructurecategory::getAllData');
    $routes->get('getDataModal', 'M_infrastructurecategory::getDataModal');
    
});
$parent='/minfrastructure';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_infrastructure::index');
    $routes->get('add', 'M_infrastructure::add');
    $routes->post('addsave', 'M_infrastructure::addsave');
    $routes->get('edit/(:num)', 'M_infrastructure::edit/$1');
    $routes->post('editsave', 'M_infrastructure::editsave');
    $routes->post('delete', 'M_infrastructure::delete');
    $routes->get('getAllData', 'M_infrastructure::getAllData');
    $routes->get('getDataModal', 'M_infrastructure::getDataModal');
    $routes->post('getData', 'M_infrastructure::getData');
    $routes->get('map', 'M_infrastructure::map');
});

// $routes->group('/mlivestock', function ($routes) {
//     $routes->get('', 'M_livestock::index');
//     $routes->get('add', 'M_livestock::add');
//     $routes->post('addsave', 'M_livestock::addsave');
//     $routes->get('edit/(:num)', 'M_livestock::edit/$1');
//     $routes->post('editsave', 'M_livestock::editsave');
//     $routes->post('delete', 'M_livestock::delete');
//     $routes->get('getAllData', 'M_livestock::getAllData');
//     $routes->get('getDataModal', 'M_livestock::getDataModal');
//     $routes->post('getData', 'M_livestock::getData');
// });

$parent='/mequipment';
$routes->group('/mequipment', function ($routes) {
    $routes->get('/', 'M_equipment::index');
    $routes->get('add', 'M_equipment::add');
    $routes->post('addsave', 'M_equipment::addsave');
    $routes->get('edit/(:num)', 'M_equipment::edit/$1');
    $routes->post('editsave', 'M_equipment::editsave');
    $routes->post('delete', 'M_equipment::delete');
    $routes->get('getAllData', 'M_equipment::getAllData');
    $routes->get('getDataModal', 'M_equipment::getDataModal');
    $routes->post('getData', 'M_equipment::getData');
    $routes->get('getOwner/(:num)', 'M_equipment::getOwner');
    $routes->post('saveOwner', 'M_equipment::saveOwner');
    
});
$parent='/mequipmentowner';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'M_equipmentowner::index');
    $routes->get('add/(:num)', 'M_equipmentowner::add');
    $routes->post('addsave', 'M_equipmentowner::addsave');
    $routes->get('edit/(:num)', 'M_equipmentowner::edit/$1');
    $routes->post('editsave', 'M_equipmentowner::editsave');
    $routes->post('delete', 'M_equipmentowner::delete');
    $routes->get('getAllData/(:num)', 'M_equipmentowner::getAllData');
    $routes->get('getDataModal', 'M_equipmentowner::getDataModal');
    $routes->post('getData', 'M_equipmentowner::getData');
});

// $routes->group('/mvillagedisaster', function ($routes) {
//     $routes->get('', 'M_villagedisaster::index');
//     $routes->get('add', 'M_villagedisaster::add');
//     $routes->post('addsave', 'M_villagedisaster::addsave');
//     $routes->get('edit/(:num)', 'M_villagedisaster::edit/$1');
//     $routes->post('editsave', 'M_villagedisaster::editsave');
//     $routes->post('delete', 'M_villagedisaster::delete');
//     $routes->get('getAllData', 'M_villagedisaster::getAllData');
//     $routes->get('getDataModal', 'M_villagedisaster::getDataModal');
//     $routes->post('getData', 'M_villagedisaster::getData');
// });

$parent='/mimpact';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_impact::index');
    $routes->get('add', 'M_impact::add');
    $routes->post('addsave', 'M_impact::addsave');
    $routes->get('edit/(:num)', 'M_impact::edit/$1');
    $routes->post('editsave', 'M_impact::editsave');
    $routes->post('delete', 'M_impact::delete');
    $routes->get('getAllData', 'M_impact::getAllData');
    $routes->get('getDataModal', 'M_impact::getDataModal');
    $routes->post('getData', 'M_impact::getData');
});

$parent='/mimpactcategory';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_impactcategory::index');
    $routes->get('add', 'M_impactcategory::add');
    $routes->post('addsave', 'M_impactcategory::addsave');
    $routes->get('edit/(:num)', 'M_impactcategory::edit/$1');
    $routes->post('editsave', 'M_impactcategory::editsave');
    $routes->post('delete', 'M_impactcategory::delete');
    $routes->get('getAllData', 'M_impactcategory::getAllData');
    $routes->get('getDataModal', 'M_impactcategory::getDataModal');
    $routes->post('getData', 'M_impactcategory::getData');
});

$parent='/mpocketbook';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_pocketbook::index');
    $routes->get('add', 'M_pocketbook::add');
    $routes->post('addsave', 'M_pocketbook::addsave');
    $routes->get('edit/(:num)', 'M_pocketbook::edit/$1');
    $routes->post('editsave', 'M_pocketbook::editsave');
    $routes->post('delete', 'M_pocketbook::delete');
    $routes->get('getAllData', 'M_pocketbook::getAllData');
    $routes->get('getDataModal', 'M_pocketbook::getDataModal');
    $routes->post('getData', 'M_pocketbook::getData');
});

$parent='/mfamilycard';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_familycard::index');
    $routes->get('add', 'M_familycard::add');
    $routes->post('addsave', 'M_familycard::addsave');
    $routes->get('edit/(:num)', 'M_familycard::edit/$1');
    $routes->post('editsave', 'M_familycard::editsave');
    $routes->post('delete', 'M_familycard::delete');
    $routes->get('getAllData', 'M_familycard::getAllData');
    $routes->get('getDataModal/(:num)', 'M_familycard::getDataModal');
    $routes->post('getData', 'M_familycard::getData');
});

$parent='/mfamilycardmember';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'M_familycardmember::index');
    $routes->get('add/(:num)', 'M_familycardmember::add/$1');
    $routes->post('addsave', 'M_familycardmember::addsave');
    $routes->get('edit/(:num)', 'M_familycardmember::edit/$1');
    $routes->post('editsave', 'M_familycardmember::editsave');
    $routes->post('delete', 'M_familycardmember::delete');
    $routes->get('getAllData/(:num)', 'M_familycardmember::getAllData/$1');
    $routes->get('getDataModal/(:num)', 'M_familycardmember::getDataModal/$1');
    $routes->post('getData', 'M_familycardmember::getData');
    $routes->post('getDataById', 'M_familycardmember::getDataById');
});



// $routes->group('/mfamilycardlivestock', function ($routes) {
//     $routes->get('(:num)', 'M_familycardlivestock::index');
//     $routes->get('add/(:num)', 'M_familycardlivestock::add');
//     $routes->post('addsave', 'M_familycardlivestock::addsave');
//     $routes->get('edit/(:num)', 'M_familycardlivestock::edit/$1');
//     $routes->post('editsave', 'M_familycardlivestock::editsave');
//     $routes->post('delete', 'M_familycardlivestock::delete');
//     $routes->get('getAllData/(:num)', 'M_familycardlivestock::getAllData');
//     $routes->get('getDataModal/(:num)', 'M_familycardlivestock::getDataModal');
//     $routes->post('getData', 'M_familycardlivestock::getData');
//     $routes->post('getDataById', 'M_familycardlivestock::getDataById');
// });

$parent = '/mdisasterschool';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_disasterschool::index');
    $routes->get('add', 'M_disasterschool::add');
    $routes->post('addsave', 'M_disasterschool::addsave');
    $routes->get('edit/(:num)', 'M_disasterschool::edit/$1');
    $routes->post('editsave', 'M_disasterschool::editsave');
    $routes->post('delete', 'M_disasterschool::delete');
    $routes->get('getAllData', 'M_disasterschool::getAllData');
    $routes->get('getDataModal', 'M_disasterschool::getDataModal');
    $routes->post('getData', 'M_disasterschool::getData');
});

$parent = '/minstance';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_instance::index');
    $routes->get('add', 'M_instance::add');
    $routes->post('addsave', 'M_instance::addsave');
    $routes->get('edit/(:num)', 'M_instance::edit/$1');
    $routes->post('editsave', 'M_instance::editsave');
    $routes->post('delete', 'M_instance::delete');
    $routes->get('getAllData', 'M_instance::getAllData');
    $routes->get('getDataModal', 'M_instance::getDataModal');
    $routes->post('getData', 'M_instance::getData');
});

$parent = '/mcapability';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_capability::index');
    $routes->get('add', 'M_capability::add');
    $routes->post('addsave', 'M_capability::addsave');
    $routes->get('edit/(:num)', 'M_capability::edit/$1');
    $routes->post('editsave', 'M_capability::editsave');
    $routes->post('delete', 'M_capability::delete');
    $routes->get('getAllData', 'M_capability::getAllData');
    $routes->get('getDataModal', 'M_capability::getDataModal');
    $routes->post('getData', 'M_capability::getData');
    
});
$parent = '/mcommunity';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_community::index');
    $routes->get('add', 'M_community::add');
    $routes->post('addsave', 'M_community::addsave');
    $routes->get('edit/(:num)', 'M_community::edit/$1');
    $routes->post('editsave', 'M_community::editsave');
    $routes->post('delete', 'M_community::delete');
    $routes->get('getAllData', 'M_community::getAllData');
    $routes->get('getDataModal', 'M_community::getDataModal');
    $routes->post('getData', 'M_community::getData');
});

$parent = '/mvolunteer';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_volunteer::index');
    $routes->get('add', 'M_volunteer::add');
    $routes->post('addsave', 'M_volunteer::addsave');
    $routes->get('edit/(:num)', 'M_volunteer::edit/$1');
    $routes->post('editsave', 'M_volunteer::editsave');
    $routes->post('delete', 'M_volunteer::delete');
    $routes->get('getAllData', 'M_volunteer::getAllData');
    $routes->get('getDataModal', 'M_volunteer::getDataModal');
    $routes->post('getData', 'M_volunteer::getData');
});

$parent = '/muom';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_uom::index');
    $routes->get('add', 'M_uom::add');
    $routes->post('addsave', 'M_uom::addsave');
    $routes->get('edit/(:num)', 'M_uom::edit/$1');
    $routes->post('editsave', 'M_uom::editsave');
    $routes->post('delete', 'M_uom::delete');
    $routes->get('getAllData', 'M_uom::getAllData');
    $routes->get('getDataModal', 'M_uom::getDataModal');
    $routes->post('getData', 'M_uom::getData');
});

$parent = '/mwarehouse';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_warehouse::index');
    $routes->get('add', 'M_warehouse::add');
    $routes->post('addsave', 'M_warehouse::addsave');
    $routes->get('edit/(:num)', 'M_warehouse::edit/$1');
    $routes->post('editsave', 'M_warehouse::editsave');
    $routes->post('delete', 'M_warehouse::delete');
    $routes->get('getAllData', 'M_warehouse::getAllData');
    $routes->get('getDataModal', 'M_warehouse::getDataModal');
    $routes->post('getData', 'M_warehouse::getData');
});

$parent = '/mitem';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_item::index');
    $routes->get('add', 'M_item::add');
    $routes->post('addsave', 'M_item::addsave');
    $routes->get('edit/(:num)', 'M_item::edit/$1');
    $routes->post('editsave', 'M_item::editsave');
    $routes->post('delete', 'M_item::delete');
    $routes->get('itemstock/(:num)', 'M_item::itemstock/$1');
    $routes->get('getAllData', 'M_item::getAllData');
    $routes->get('getDataModal', 'M_item::getDataModal');
    $routes->post('getData', 'M_item::getData');
    $routes->get('getStock/(:num)', 'M_item::getStock/$1');
});

$parent = '/tdisasterreport';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasterreport::index');
    $routes->get('add', 'T_disasterreport::add');
    $routes->post('addsave', 'T_disasterreport::addsave');
    $routes->get('edit/(:num)', 'T_disasterreport::edit/$1');
    $routes->post('editsave', 'T_disasterreport::editsave');
    $routes->post('delete', 'T_disasterreport::delete');
    $routes->get('getAllData', 'T_disasterreport::getAllData');
    $routes->get('getDataModal', 'T_disasterreport::getDataModal');
    $routes->post('getData', 'T_disasterreport::getData');
    $routes->post('getDataById', 'T_disasterreport::getDataById');
    $routes->get('disasterreport', 'T_disasterreport::addpublic');
    $routes->post('disasterreportsave', 'T_disasterreport::savepublic');
});

$parent = '/tdisasteroccur';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasteroccur::index');
    $routes->get('add', 'T_disasteroccur::add');
    $routes->post('addsave', 'T_disasteroccur::addsave');
    $routes->get('edit/(:num)', 'T_disasteroccur::edit/$1');
    $routes->post('editsave', 'T_disasteroccur::editsave');
    $routes->post('delete', 'T_disasteroccur::delete');
    $routes->get('getAllData', 'T_disasteroccur::getAllData');
    $routes->get('getDataModal', 'T_disasteroccur::getDataModal');
    $routes->post('getData', 'T_disasteroccur::getData');
    $routes->post('getDataById', 'T_disasteroccur::getDataById');
});

$parent = '/msafedistance';
$routes->group('/msafedistance', function ($routes) {
    $routes->get('/', 'M_safedistance::index');
    $routes->get('add', 'M_safedistance::add');
    $routes->post('addsave', 'M_safedistance::addsave');
    $routes->get('edit/(:num)', 'M_safedistance::edit/$1');
    $routes->post('editsave', 'M_safedistance::editsave');
    $routes->post('delete', 'M_safedistance::delete');
    $routes->get('getAllData', 'M_safedistance::getAllData');
    $routes->get('getDataModal', 'M_safedistance::getDataModal');
    $routes->post('getData', 'M_safedistance::getData');
});

$parent = '/moccupation';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_occupation::index');
    $routes->get('add', 'M_occupation::add');
    $routes->post('addsave', 'M_occupation::addsave');
    $routes->get('edit/(:num)', 'M_occupation::edit/$1');
    $routes->post('editsave', 'M_occupation::editsave');
    $routes->post('delete', 'M_occupation::delete');
    $routes->get('getAllData', 'M_occupation::getAllData');
    $routes->get('getDataModal', 'M_occupation::getDataModal');
    $routes->post('getData', 'M_occupation::getData');
});

$parent = '/memployee';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_employee::index');
    $routes->get('add', 'M_employee::add');
    $routes->post('addsave', 'M_employee::addsave');
    $routes->get('edit/(:num)', 'M_employee::edit/$1');
    $routes->post('editsave', 'M_employee::editsave');
    $routes->post('delete', 'M_employee::delete');
    $routes->get('getAllData', 'M_employee::getAllData');
    $routes->get('getDataModal', 'M_employee::getDataModal');
    $routes->post('getData', 'M_employee::getData');
});

$parent = '/tdisasteroccurimpact';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurimpact::index/$1');
    $routes->get('add/(:num)', 'T_disasteroccurimpact::add/$1');
    $routes->post('addsave', 'T_disasteroccurimpact::addsave');
    $routes->get('edit/(:num)', 'T_disasteroccurimpact::edit/$1');
    $routes->post('editsave', 'T_disasteroccurimpact::editsave');
    $routes->post('delete', 'T_disasteroccurimpact::delete');
    $routes->get('getAllData/(:num)', 'T_disasteroccurimpact::getAllData/$1');
    $routes->get('getDataModal', 'T_disasteroccurimpact::getDataModal');
    $routes->post('getData', 'T_disasteroccurimpact::getData');
});

$parent = '/tdisasteroccurvictim';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurvictim::index/$1');
    $routes->get('add/(:num)', 'T_disasteroccurvictim::add/$1');
    $routes->post('addsave', 'T_disasteroccurvictim::addsave');
    $routes->get('edit/(:num)', 'T_disasteroccurvictim::edit/$1');
    $routes->post('editsave', 'T_disasteroccurvictim::editsave');
    $routes->post('delete', 'T_disasteroccurvictim::delete');
    $routes->get('getAllData/(:num)', 'T_disasteroccurvictim::getAllData/$1');
    $routes->get('getDataModal', 'T_disasteroccurvictim::getDataModal');
    $routes->post('getData', 'T_disasteroccurvictim::getData');
});

$parent = '/tdisasteroccurbuilding';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurbuilding::index/$1');
    $routes->get('add/(:num)', 'T_disasteroccurbuilding::add/$1');
    $routes->post('addsave', 'T_disasteroccurbuilding::addsave');
    $routes->get('edit/(:num)', 'T_disasteroccurbuilding::edit/$1');
    $routes->post('editsave', 'T_disasteroccurbuilding::editsave');
    $routes->post('delete', 'T_disasteroccurbuilding::delete');
    $routes->get('getAllData/(:num)', 'T_disasteroccurbuilding::getAllData/$1');
    $routes->get('getDataModal', 'T_disasteroccurbuilding::getDataModal');
    $routes->post('getData', 'T_disasteroccurbuilding::getData');
});

$parent = '/tdisasteroccurlogistic';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurlogistic::index/$1');
    $routes->get('add/(:num)', 'T_disasteroccurlogistic::add/$1');
    $routes->post('addsave', 'T_disasteroccurlogistic::addsave');
    $routes->get('edit/(:num)', 'T_disasteroccurlogistic::edit/$1');
    $routes->post('editsave', 'T_disasteroccurlogistic::editsave');
    $routes->post('delete', 'T_disasteroccurlogistic::delete');
    $routes->get('getAllData/(:num)', 'T_disasteroccurlogistic::getAllData/$1');
    $routes->get('getDataModal', 'T_disasteroccurlogistic::getDataModal');
    $routes->post('getData', 'T_disasteroccurlogistic::getData');
});

$parent = '/mearlywarning';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_earlywarning::index');
    $routes->get('add', 'M_earlywarning::add');
    $routes->post('addsave', 'M_earlywarning::addsave');
    $routes->get('edit/(:num)', 'M_earlywarning::edit/$1');
    $routes->post('editsave', 'M_earlywarning::editsave');
    $routes->post('delete', 'M_earlywarning::delete');
    $routes->get('getAllData', 'M_earlywarning::getAllData');
    $routes->get('getDataModal', 'M_earlywarning::getDataModal');
    $routes->post('getData', 'M_earlywarning::getData');
});

$parent = '/tinoutitem';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_inoutitem::index');
    $routes->get('add', 'T_inoutitem::add');
    $routes->post('addsave', 'T_inoutitem::addsave');
    $routes->get('edit/(:num)', 'T_inoutitem::edit/$1');
    $routes->post('editsave', 'T_inoutitem::editsave');;
    $routes->get('copy/(:num)', 'T_inoutitem::copy/$1');
    $routes->post('delete', 'T_inoutitem::delete');
    $routes->get('getAllData', 'T_inoutitem::getAllData');
    $routes->get('getDataModal', 'T_inoutitem::getDataModal');
    $routes->post('getData', 'T_inoutitem::getData');
    $routes->post('getDataById', 'T_inoutitem::getDataById');
});


$parent = '/tinoutitemdetail';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_inoutitemdetail::index/$1');
    $routes->get('add/(:num)', 'T_inoutitemdetail::add/$1');
    $routes->post('addsave', 'T_inoutitemdetail::addsave');
    $routes->get('edit/(:num)', 'T_inoutitemdetail::edit/$1');
    $routes->post('editsave', 'T_inoutitemdetail::editsave');
    $routes->post('delete', 'T_inoutitemdetail::delete');
    $routes->get('getAllData/(:num)', 'T_inoutitemdetail::getAllData/$1');
    $routes->get('getDataModal/(:num)', 'T_inoutitemdetail::getDataModal/$1');
    $routes->post('getData', 'T_inoutitemdetail::getData');
    $routes->post('getDataById', 'T_inoutitemdetail::getDataById');
});

$parent = '/setting';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_form::index');
    $routes->post('savedisasterreport', 'M_form::savedisasterreport');
    $routes->post('savedisasteroccur', 'M_form::savedisasteroccur');
    $routes->post('saveinoutitem', 'M_form::saveinoutitem');
    $routes->post('saveuserlocation', 'M_form::saveuserlocation');
    $routes->post('saveimpactcompensation', 'M_form::saveimpactcompensation');
    
});

$parent = '/tdisasterassessment';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasterassessment::index');
    $routes->get('add', 'T_disasterassessment::add');
    $routes->post('addsave', 'T_disasterassessment::addsave');
    $routes->get('edit/(:num)', 'T_disasterassessment::edit/$1');
    $routes->post('editsave', 'T_disasterassessment::editsave');
    $routes->post('delete', 'T_disasterassessment::delete');
    $routes->get('getAllData', 'T_disasterassessment::getAllData');
    $routes->get('getDataModal', 'T_disasterassessment::getDataModal');
    $routes->post('getData', 'T_disasterassessment::getData');
    $routes->post('getDataById', 'T_disasterassessment::getDataById');
    
});


$parent = '/tdisasterassessmentimpact';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasterassessmentimpact::index/$1');
    $routes->get('add/(:num)', 'T_disasterassessmentimpact::add/$1');
    $routes->post('addsave', 'T_disasterassessmentimpact::addsave');
    $routes->get('edit/(:num)', 'T_disasterassessmentimpact::edit/$1');
    $routes->post('editsave', 'T_disasterassessmentimpact::editsave');
    $routes->post('delete', 'T_disasterassessmentimpact::delete');
    $routes->get('getAllData/(:num)', 'T_disasterassessmentimpact::getAllData/$1');
    $routes->get('getDataModal', 'T_disasterassessmentimpact::getDataModal');
    $routes->post('getData', 'T_disasterassessmentimpact::getData');
});

// /**
//  * Reports
//  */
// $routes->group('/report', function ($routes) {
//     $routes->group('/disaster', function ($routes) {

//         $routes->get('', 'Reports\R_Disaster::viewdisaster');
//         $routes->post('print', 'Reports\R_Disaster::printreport');
//     });


//     $routes->group('/population', function ($routes) {

//         $routes->get('', 'Reports\R_Population::viewpopulation');
//         $routes->post('print', 'Reports\R_Population::printreport');
//     });


//     $routes->group('/inoutitem', function ($routes) {

//         $routes->get('', 'Reports\R_Inoutitem::viewinoutitem');
//         $routes->post('print', 'Reports\R_Inoutitem::printreport');
//     });
// });
// /** End reports */
// $routes->get('test', 'Test::index');
// $routes->get('testsave', 'Test::testsave');
// $routes->get('datatableGet', 'Test::datatableGet');
// $routes->get('gettest', 'Test::gettest');
// $routes->post('submittest', 'Test::submittest');

// // $routes->controller('/contact', 'App\Controller\Contact');
// //REST api
$routes->group('/api', function ($routes) {
    $routes->get('login/(:alphanum)/(:alphanum)', 'Rests\User::login/$1/$2');
    $routes->get('company', 'Rests\Company::getCompany');

    $routes->group('province', function ($routes) {
        $routes->get('getprovinces', 'Rests\ApiMProvince::findProvince');
        $routes->post('postprovinces', 'Rests\ApiMProvince::postProvince');
        $routes->put('putprovinces', 'Rests\ApiMProvince::putProvince');
        $routes->delete('deleteprovinces/(:num)', 'Rests\ApiMProvince::deleteProvince/$1');
    });

    $routes->group('user', function ($routes) {
        $routes->get('login/(:alphanum)/(:alphanum)', 'Rests\User::login/$1/$2');
        $routes->post('createuserlocation', 'Rests\User::postUserLocation');
        $routes->get('userlocation', 'Rests\User::getUserLocation');
        $routes->put('startmoving', 'Rests\User::startMoving');
    });

    $routes->group('disasteroccur', function ($routes) {
        $routes->get('list', 'Rests\DisasterOccur::getDisasterOccurs');
        $routes->get('detail/(:num)', 'Rests\DisasterOccur::getDisasteOccurById/$1');
        $routes->post('create', 'Rests\DisasterOccur::postDisasterOccur');
        $routes->get('victims/(:num)', 'Rests\DisasterOccurVictim::getDisasterOccurVictims/$1');
        $routes->get('impacts/(:num)', 'Rests\DisasterOccurImpact::getDisasterOccurImpacts/$1');
        $routes->get('buildings/(:num)', 'Rests\DisasterOccurBuilding::getDisasterOccurBuildings/$1');
        $routes->post('victim/create', 'Rests\DisasterOccurVictim::postDisasterOccurVictim');
        $routes->delete('victim/delete/(:num)', 'Rests\DisasterOccurVictim::deleteVictim/$1');
        $routes->post('building/create', 'Rests\DisasterOccurBuilding::postDisasterOccurBuilding');
        $routes->delete('building/delete/(:num)', 'Rests\DisasterOccurBuilding::deleteBuilding/$1');
        $routes->post('impact/create', 'Rests\DisasterOccurImpact::postDisasterOccurImpact');
        $routes->delete('impact/delete/(:num)', 'Rests\DisasterOccurImpact::deleteImpact/$1');
        $routes->put('handle', 'Rests\DisasterOccur::handle');
    });

    $routes->group('disasterreport', function ($routes) {
        $routes->get('list', 'Rests\DisasterReport::getDisasterReports');
        $routes->get('detail/(:num)', 'Rests\DisasterReport::getDisasterReportById/$1');
        $routes->get('listbyphone/(:num)', 'Rests\DisasterReport::getDisasterReportsByPhone/$1');
        $routes->get('report/(:num)', 'Rests\DisasterReport::getDisasterReportsByNo/$1');
        $routes->post('create', 'Rests\DisasterReport::postDisasterReport');
        $routes->post('actualReport', 'Rests\DisasterReport::postActualReport');
        $routes->put('handle', 'Rests\DisasterReport::handle');
        $routes->delete('delete/(:num)', 'Rests\DisasterReport::deleteDisasterReport/$1');
    });

    $routes->group('familycard', function ($routes) {
        $routes->get('list', 'Rests\FamilyCard::getFamilyCard');
        $routes->get('members', 'Rests\FamilyCard::getFamilyCardMember');
        $routes->get('member/(:num)', 'Rests\FamilyCard::getFamilyCardMemberById/$1');
        $routes->get('indisasteroccur/(:num)', 'Rests\FamilyCard::getFamilyCardInOccur');
    });

    $routes->group('disaster', function ($routes) {
        $routes->get('list', 'Rests\Disaster::getDisasters');
    });

    $routes->group('groupuser', function ($routes) {
        $routes->get('list', 'Rests\MGroupuser::getGroupusers');
        $routes->post('create', 'Rests\MGroupuser::postData');
        $routes->put('update/(:num)', 'Rests\MGroupuser::putData/$1');
        $routes->get('get/(:num)', 'Rests\MGroupuser::getDataById/$1');
    });

    $routes->group('user', function ($routes) {
        $routes->get('list', 'Rests\MUser::getUsers');
    });

    $routes->group('pocketbook', function ($routes) {
        $routes->get('list', 'Rests\PocketBook::getPocketbooks');
    });

    $routes->group('public', function ($routes) {
        $routes->get('register/(:num)', 'Rests\Reporter::registerPhone/$1');
        $routes->post('verify', 'Rests\Reporter::verify');
    });

    $routes->group('broadcast', function ($routes) {
        $routes->get('list', 'Rests\Broadcast::getBroadcasts');
        $routes->get('detail/(:num)', 'Rests\Broadcast::getBroadcastById/$1');
    });

    $routes->group('subvillage', function ($routes) {
        $routes->get('list', 'Rests\Subvillage::getSubvillages');
    });

    $routes->group('impact', function ($routes) {
        $routes->get('list', 'Rests\Impact::getImpacts');
    });
});


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional routes files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
