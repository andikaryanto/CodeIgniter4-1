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
$routes->set404Override();
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
$routes->get($parent.'/filter', 'Welcome::filter');

$parent='/login';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'Login::index');
});
$routes->post($parent.'/dologin', 'Login::dologin');
$routes->get($parent.'/dologout', 'Login::dologout');


$parent='/reports';
$routes->group('/reports', function ($routes) {
    $routes->get('/', 'Report::index');
});
$routes->get($parent.'/getAllData', 'Report::getAllData');

$parent='/mgroupuser';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_groupuser::index');
});
$routes->get($parent.'/add', 'M_groupuser::add');
$routes->post($parent.'/addsave', 'M_groupuser::addsave');
$routes->get($parent.'/edit/(:num)', 'M_groupuser::edit/$1');
$routes->post($parent.'/editsave', 'M_groupuser::editsave');
$routes->post($parent.'/delete', 'M_groupuser::delete');
$routes->get($parent.'/editrole/(:num)', 'M_groupuser::editrole');
$routes->post($parent.'/saverole', 'M_groupuser::saverole');
$routes->post($parent.'/savereportrole', 'M_groupuser::savereportrole');
$routes->get($parent.'/editreportrole/(:num)', 'M_groupuser::editreportrole');
$routes->get($parent.'/getAllData', 'M_groupuser::getAllData');
$routes->get($parent.'/getDataModal', 'M_groupuser::getDataModal');


$parent='/muser';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_user::index');
});
$routes->get($parent.'/add', 'M_user::add');
$routes->post($parent.'/addsave', 'M_user::addsave');
$routes->get($parent.'/edit/(:num)', 'M_user::edit/$1');
$routes->post($parent.'/editsave', 'M_user::editsave');
$routes->post($parent.'/delete', 'M_user::delete');
$routes->get($parent.'/getAllData', 'M_user::getAllData');

$routes->group('/muserlocation', function ($routes) {
    $routes->get('/', 'M_userlocation::index');
});

$parent='/mprovince';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_province::index');
});
$routes->get($parent.'/add', 'M_province::add');
$routes->post($parent.'/addsave', 'M_province::addsave');
$routes->get($parent.'/edit/(:num)', 'M_province::edit/$1');
$routes->post($parent.'/editsave', 'M_province::editsave');
$routes->post($parent.'/delete', 'M_province::delete');
$routes->get($parent.'/getAllData', 'M_province::getAllData');
$routes->get($parent.'/getDataModal', 'M_province::getDataModal');

$parent='/mcompany';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_company::add');
});
$routes->post($parent.'/addsave', 'M_company::addsave');

$parent='/mdistrict';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_district::index');
});
$routes->get($parent.'/add', 'M_district::add');
$routes->post($parent.'/addsave', 'M_district::addsave');
$routes->get($parent.'/edit/(:num)', 'M_district::edit/$1');
$routes->post($parent.'/editsave', 'M_district::editsave');
$routes->post($parent.'/delete', 'M_district::delete');
$routes->get($parent.'/getAllData', 'M_district::getAllData');
$routes->get($parent.'/getDataModal', 'M_district::getDataModal');

$parent='/msubdistrict';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_subdistrict::index');
});
$routes->get($parent.'/add', 'M_subdistrict::add');
$routes->post($parent.'/addsave', 'M_subdistrict::addsave');
$routes->get($parent.'/edit/(:num)', 'M_subdistrict::edit/$1');
$routes->post($parent.'/editsave', 'M_subdistrict::editsave');
$routes->post($parent.'/delete', 'M_subdistrict::delete');
$routes->get($parent.'/getAllData', 'M_subdistrict::getAllData');
$routes->get($parent.'/getDataModal', 'M_subdistrict::getDataModal');

$parent='/mvillage';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_village::index');
});
$routes->get($parent.'/add', 'M_village::add');
$routes->post($parent.'/addsave', 'M_village::addsave');
$routes->get($parent.'/edit/(:num)', 'M_village::edit/$1');
$routes->post($parent.'/editsave', 'M_village::editsave');
$routes->post($parent.'/delete', 'M_village::delete');
$routes->get($parent.'/getAllData', 'M_village::getAllData');
$routes->get($parent.'/getDataModal', 'M_village::getDataModal');

$parent='/msubvillage';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_subvillage::index');
});
$routes->get($parent.'/add', 'M_subvillage::add');
$routes->post($parent.'/addsave', 'M_subvillage::addsave');
$routes->get($parent.'/edit/(:num)', 'M_subvillage::edit/$1');
$routes->post($parent.'/editsave', 'M_subvillage::editsave');
$routes->post($parent.'/delete', 'M_subvillage::delete');
$routes->get($parent.'/getAllData', 'M_subvillage::getAllData');
$routes->get($parent.'/getDataModal', 'M_subvillage::getDataModal');

$parent='/mdisaster';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_disaster::index');
});
$routes->get($parent.'/add', 'M_disaster::add');
$routes->post($parent.'/addsave', 'M_disaster::addsave');
$routes->get($parent.'/edit/(:num)', 'M_disaster::edit/$1');
$routes->post($parent.'/editsave', 'M_disaster::editsave');
$routes->post($parent.'/delete', 'M_disaster::delete');
$routes->get($parent.'/getAllData', 'M_disaster::getAllData');
$routes->get($parent.'/getDataModal', 'M_disaster::getDataModal');

$parent='/minfrastructurecategory';
$routes->group('/minfrastructurecategory', function ($routes) {
    $routes->get('/', 'M_infrastructurecategory::index');
});
$routes->get($parent.'/add', 'M_infrastructurecategory::add');
$routes->post($parent.'/addsave', 'M_infrastructurecategory::addsave');
$routes->get($parent.'/edit/(:num)', 'M_infrastructurecategory::edit/$1');
$routes->post($parent.'/editsave', 'M_infrastructurecategory::editsave');
$routes->post($parent.'/delete', 'M_infrastructurecategory::delete');
$routes->get($parent.'/getAllData', 'M_infrastructurecategory::getAllData');
$routes->get($parent.'/getDataModal', 'M_infrastructurecategory::getDataModal');

$parent='/minfrastructure';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_infrastructure::index');
});
$routes->get($parent.'/add', 'M_infrastructure::add');
$routes->post($parent.'/addsave', 'M_infrastructure::addsave');
$routes->get($parent.'/edit/(:num)', 'M_infrastructure::edit/$1');
$routes->post($parent.'/editsave', 'M_infrastructure::editsave');
$routes->post($parent.'/delete', 'M_infrastructure::delete');
$routes->get($parent.'/getAllData', 'M_infrastructure::getAllData');
$routes->get($parent.'/getDataModal', 'M_infrastructure::getDataModal');
$routes->post($parent.'/getData', 'M_infrastructure::getData');
$routes->get($parent.'/map', 'M_infrastructure::map');

// $routes->group('/mlivestock', function ($routes) {
//     $routes->get($parent.'/', 'M_livestock::index');
//     $routes->get($parent.'/add', 'M_livestock::add');
//     $routes->post($parent.'/addsave', 'M_livestock::addsave');
//     $routes->get($parent.'/edit/(:num)', 'M_livestock::edit/$1');
//     $routes->post($parent.'/editsave', 'M_livestock::editsave');
//     $routes->post($parent.'/delete', 'M_livestock::delete');
//     $routes->get($parent.'/getAllData', 'M_livestock::getAllData');
//     $routes->get($parent.'/getDataModal', 'M_livestock::getDataModal');
//     $routes->post($parent.'/getData', 'M_livestock::getData');
// });

$parent='/mequipment';
$routes->group('/mequipment', function ($routes) {
    $routes->get('/', 'M_equipment::index');
});
$routes->get($parent.'/add', 'M_equipment::add');
$routes->post($parent.'/addsave', 'M_equipment::addsave');
$routes->get($parent.'/edit/(:num)', 'M_equipment::edit/$1');
$routes->post($parent.'/editsave', 'M_equipment::editsave');
$routes->post($parent.'/delete', 'M_equipment::delete');
$routes->get($parent.'/getAllData', 'M_equipment::getAllData');
$routes->get($parent.'/getDataModal', 'M_equipment::getDataModal');
$routes->post($parent.'/getData', 'M_equipment::getData');
$routes->get($parent.'/getOwner/(:num)', 'M_equipment::getOwner');
$routes->post($parent.'/saveOwner', 'M_equipment::saveOwner');

$parent='/mequipmentowner';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'M_equipmentowner::index');
});
$routes->get($parent.'/add/(:num)', 'M_equipmentowner::add');
$routes->post($parent.'/addsave', 'M_equipmentowner::addsave');
$routes->get($parent.'/edit/(:num)', 'M_equipmentowner::edit/$1');
$routes->post($parent.'/editsave', 'M_equipmentowner::editsave');
$routes->post($parent.'/delete', 'M_equipmentowner::delete');
$routes->get($parent.'/getAllData/(:num)', 'M_equipmentowner::getAllData');
$routes->get($parent.'/getDataModal', 'M_equipmentowner::getDataModal');
$routes->post($parent.'/getData', 'M_equipmentowner::getData');

// $routes->group('/mvillagedisaster', function ($routes) {
//     $routes->get($parent.'/', 'M_villagedisaster::index');
//     $routes->get($parent.'/add', 'M_villagedisaster::add');
//     $routes->post($parent.'/addsave', 'M_villagedisaster::addsave');
//     $routes->get($parent.'/edit/(:num)', 'M_villagedisaster::edit/$1');
//     $routes->post($parent.'/editsave', 'M_villagedisaster::editsave');
//     $routes->post($parent.'/delete', 'M_villagedisaster::delete');
//     $routes->get($parent.'/getAllData', 'M_villagedisaster::getAllData');
//     $routes->get($parent.'/getDataModal', 'M_villagedisaster::getDataModal');
//     $routes->post($parent.'/getData', 'M_villagedisaster::getData');
// });

$parent='/mequipmentowner';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_impact::index');
});
$routes->get($parent.'/add', 'M_impact::add');
$routes->post($parent.'/addsave', 'M_impact::addsave');
$routes->get($parent.'/edit/(:num)', 'M_impact::edit/$1');
$routes->post($parent.'/editsave', 'M_impact::editsave');
$routes->post($parent.'/delete', 'M_impact::delete');
$routes->get($parent.'/getAllData', 'M_impact::getAllData');
$routes->get($parent.'/getDataModal', 'M_impact::getDataModal');
$routes->post($parent.'/getData', 'M_impact::getData');

$parent='/mimpactcategory';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_impactcategory::index');
});
$routes->get($parent.'/add', 'M_impactcategory::add');
$routes->post($parent.'/addsave', 'M_impactcategory::addsave');
$routes->get($parent.'/edit/(:num)', 'M_impactcategory::edit/$1');
$routes->post($parent.'/editsave', 'M_impactcategory::editsave');
$routes->post($parent.'/delete', 'M_impactcategory::delete');
$routes->get($parent.'/getAllData', 'M_impactcategory::getAllData');
$routes->get($parent.'/getDataModal', 'M_impactcategory::getDataModal');
$routes->post($parent.'/getData', 'M_impactcategory::getData');

$parent='/mpocketbook';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_pocketbook::index');
});
$routes->get($parent.'/add', 'M_pocketbook::add');
$routes->post($parent.'/addsave', 'M_pocketbook::addsave');
$routes->get($parent.'/edit/(:num)', 'M_pocketbook::edit/$1');
$routes->post($parent.'/editsave', 'M_pocketbook::editsave');
$routes->post($parent.'/delete', 'M_pocketbook::delete');
$routes->get($parent.'/getAllData', 'M_pocketbook::getAllData');
$routes->get($parent.'/getDataModal', 'M_pocketbook::getDataModal');
$routes->post($parent.'/getData', 'M_pocketbook::getData');

$parent='/mfamilycard';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_familycard::index');
});
$routes->get($parent.'/add', 'M_familycard::add');
$routes->post($parent.'/addsave', 'M_familycard::addsave');
$routes->get($parent.'/edit/(:num)', 'M_familycard::edit/$1');
$routes->post($parent.'/editsave', 'M_familycard::editsave');
$routes->post($parent.'/delete', 'M_familycard::delete');
$routes->get($parent.'/getAllData', 'M_familycard::getAllData');
$routes->get($parent.'/getDataModal/(:num)', 'M_familycard::getDataModal');
$routes->post($parent.'/getData', 'M_familycard::getData');

$parent='/mfamilycardmember';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'M_familycardmember::index');
});
$routes->get($parent.'/add/(:num)', 'M_familycardmember::add/$1');
$routes->post($parent.'/addsave', 'M_familycardmember::addsave');
$routes->get($parent.'/edit/(:num)', 'M_familycardmember::edit/$1');
$routes->post($parent.'/editsave', 'M_familycardmember::editsave');
$routes->post($parent.'/delete', 'M_familycardmember::delete');
$routes->get($parent.'/getAllData/(:num)', 'M_familycardmember::getAllData/$1');
$routes->get($parent.'/getDataModal/(:num)', 'M_familycardmember::getDataModal/$1');
$routes->post($parent.'/getData', 'M_familycardmember::getData');
$routes->post($parent.'/getDataById', 'M_familycardmember::getDataById');



// $routes->group('/mfamilycardlivestock', function ($routes) {
//     $routes->get($parent.'/(:num)', 'M_familycardlivestock::index');
//     $routes->get($parent.'/add/(:num)', 'M_familycardlivestock::add');
//     $routes->post($parent.'/addsave', 'M_familycardlivestock::addsave');
//     $routes->get($parent.'/edit/(:num)', 'M_familycardlivestock::edit/$1');
//     $routes->post($parent.'/editsave', 'M_familycardlivestock::editsave');
//     $routes->post($parent.'/delete', 'M_familycardlivestock::delete');
//     $routes->get($parent.'/getAllData/(:num)', 'M_familycardlivestock::getAllData');
//     $routes->get($parent.'/getDataModal/(:num)', 'M_familycardlivestock::getDataModal');
//     $routes->post($parent.'/getData', 'M_familycardlivestock::getData');
//     $routes->post($parent.'/getDataById', 'M_familycardlivestock::getDataById');
// });

$parent = '/mdisasterschool';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_disasterschool::index');
});
$routes->get($parent.'/add', 'M_disasterschool::add');
$routes->post($parent.'/addsave', 'M_disasterschool::addsave');
$routes->get($parent.'/edit/(:num)', 'M_disasterschool::edit/$1');
$routes->post($parent.'/editsave', 'M_disasterschool::editsave');
$routes->post($parent.'/delete', 'M_disasterschool::delete');
$routes->get($parent.'/getAllData', 'M_disasterschool::getAllData');
$routes->get($parent.'/getDataModal', 'M_disasterschool::getDataModal');
$routes->post($parent.'/getData', 'M_disasterschool::getData');

$parent = '/mdisasterschool';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_instance::index');
});
$routes->get($parent.'/add', 'M_instance::add');
$routes->post($parent.'/addsave', 'M_instance::addsave');
$routes->get($parent.'/edit/(:num)', 'M_instance::edit/$1');
$routes->post($parent.'/editsave', 'M_instance::editsave');
$routes->post($parent.'/delete', 'M_instance::delete');
$routes->get($parent.'/getAllData', 'M_instance::getAllData');
$routes->get($parent.'/getDataModal', 'M_instance::getDataModal');
$routes->post($parent.'/getData', 'M_instance::getData');

$parent = '/mcapability';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_capability::index');
});
$routes->get($parent.'/add', 'M_capability::add');
$routes->post($parent.'/addsave', 'M_capability::addsave');
$routes->get($parent.'/edit/(:num)', 'M_capability::edit/$1');
$routes->post($parent.'/editsave', 'M_capability::editsave');
$routes->post($parent.'/delete', 'M_capability::delete');
$routes->get($parent.'/getAllData', 'M_capability::getAllData');
$routes->get($parent.'/getDataModal', 'M_capability::getDataModal');
$routes->post($parent.'/getData', 'M_capability::getData');

$parent = '/mcommunity';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_community::index');
});
$routes->get($parent.'/add', 'M_community::add');
$routes->post($parent.'/addsave', 'M_community::addsave');
$routes->get($parent.'/edit/(:num)', 'M_community::edit/$1');
$routes->post($parent.'/editsave', 'M_community::editsave');
$routes->post($parent.'/delete', 'M_community::delete');
$routes->get($parent.'/getAllData', 'M_community::getAllData');
$routes->get($parent.'/getDataModal', 'M_community::getDataModal');
$routes->post($parent.'/getData', 'M_community::getData');

$parent = '/mcommunity';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_volunteer::index');
});
$routes->get($parent.'/add', 'M_volunteer::add');
$routes->post($parent.'/addsave', 'M_volunteer::addsave');
$routes->get($parent.'/edit/(:num)', 'M_volunteer::edit/$1');
$routes->post($parent.'/editsave', 'M_volunteer::editsave');
$routes->post($parent.'/delete', 'M_volunteer::delete');
$routes->get($parent.'/getAllData', 'M_volunteer::getAllData');
$routes->get($parent.'/getDataModal', 'M_volunteer::getDataModal');
$routes->post($parent.'/getData', 'M_volunteer::getData');

$parent = '/muom';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_uom::index');
});
$routes->get($parent.'/add', 'M_uom::add');
$routes->post($parent.'/addsave', 'M_uom::addsave');
$routes->get($parent.'/edit/(:num)', 'M_uom::edit/$1');
$routes->post($parent.'/editsave', 'M_uom::editsave');
$routes->post($parent.'/delete', 'M_uom::delete');
$routes->get($parent.'/getAllData', 'M_uom::getAllData');
$routes->get($parent.'/getDataModal', 'M_uom::getDataModal');
$routes->post($parent.'/getData', 'M_uom::getData');

$parent = '/muom';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_warehouse::index');
});
$routes->get($parent.'/add', 'M_warehouse::add');
$routes->post($parent.'/addsave', 'M_warehouse::addsave');
$routes->get($parent.'/edit/(:num)', 'M_warehouse::edit/$1');
$routes->post($parent.'/editsave', 'M_warehouse::editsave');
$routes->post($parent.'/delete', 'M_warehouse::delete');
$routes->get($parent.'/getAllData', 'M_warehouse::getAllData');
$routes->get($parent.'/getDataModal', 'M_warehouse::getDataModal');
$routes->post($parent.'/getData', 'M_warehouse::getData');

$parent = '/mitem';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_item::index');
});
$routes->get($parent.'/add', 'M_item::add');
$routes->post($parent.'/addsave', 'M_item::addsave');
$routes->get($parent.'/edit/(:num)', 'M_item::edit/$1');
$routes->post($parent.'/editsave', 'M_item::editsave');
$routes->post($parent.'/delete', 'M_item::delete');
$routes->get($parent.'/itemstock/(:num)', 'M_item::itemstock/$1');
$routes->get($parent.'/getAllData', 'M_item::getAllData');
$routes->get($parent.'/getDataModal', 'M_item::getDataModal');
$routes->post($parent.'/getData', 'M_item::getData');
$routes->get($parent.'/getStock/(:num)', 'M_item::getStock/$1');

$parent = '/tdisasterreport';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasterreport::index');
});
$routes->get($parent.'/add', 'T_disasterreport::add');
$routes->post($parent.'/addsave', 'T_disasterreport::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasterreport::edit/$1');
$routes->post($parent.'/editsave', 'T_disasterreport::editsave');
$routes->post($parent.'/delete', 'T_disasterreport::delete');
$routes->get($parent.'/getAllData', 'T_disasterreport::getAllData');
$routes->get($parent.'/getDataModal', 'T_disasterreport::getDataModal');
$routes->post($parent.'/getData', 'T_disasterreport::getData');
$routes->post($parent.'/getDataById', 'T_disasterreport::getDataById');
$routes->get($parent.'/disasterreport', 'T_disasterreport::addpublic');
$routes->post($parent.'/disasterreportsave', 'T_disasterreport::savepublic');

$parent = '/tdisasteroccur';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasteroccur::index');
});
$routes->get($parent.'/add', 'T_disasteroccur::add');
$routes->post($parent.'/addsave', 'T_disasteroccur::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasteroccur::edit/$1');
$routes->post($parent.'/editsave', 'T_disasteroccur::editsave');
$routes->post($parent.'/delete', 'T_disasteroccur::delete');
$routes->get($parent.'/getAllData', 'T_disasteroccur::getAllData');
$routes->get($parent.'/getDataModal', 'T_disasteroccur::getDataModal');
$routes->post($parent.'/getData', 'T_disasteroccur::getData');
$routes->post($parent.'/getDataById', 'T_disasteroccur::getDataById');

$parent = '/msafedistance';
$routes->group('/msafedistance', function ($routes) {
    $routes->get('/', 'M_safedistance::index');
});
$routes->get($parent.'/add', 'M_safedistance::add');
$routes->post($parent.'/addsave', 'M_safedistance::addsave');
$routes->get($parent.'/edit/(:num)', 'M_safedistance::edit/$1');
$routes->post($parent.'/editsave', 'M_safedistance::editsave');
$routes->post($parent.'/delete', 'M_safedistance::delete');
$routes->get($parent.'/getAllData', 'M_safedistance::getAllData');
$routes->get($parent.'/getDataModal', 'M_safedistance::getDataModal');
$routes->post($parent.'/getData', 'M_safedistance::getData');

$parent = '/msafedistance';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_occupation::index');
});
$routes->get($parent.'/add', 'M_occupation::add');
$routes->post($parent.'/addsave', 'M_occupation::addsave');
$routes->get($parent.'/edit/(:num)', 'M_occupation::edit/$1');
$routes->post($parent.'/editsave', 'M_occupation::editsave');
$routes->post($parent.'/delete', 'M_occupation::delete');
$routes->get($parent.'/getAllData', 'M_occupation::getAllData');
$routes->get($parent.'/getDataModal', 'M_occupation::getDataModal');
$routes->post($parent.'/getData', 'M_occupation::getData');

$parent = '/memployee';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_employee::index');
});
$routes->get($parent.'/add', 'M_employee::add');
$routes->post($parent.'/addsave', 'M_employee::addsave');
$routes->get($parent.'/edit/(:num)', 'M_employee::edit/$1');
$routes->post($parent.'/editsave', 'M_employee::editsave');
$routes->post($parent.'/delete', 'M_employee::delete');
$routes->get($parent.'/getAllData', 'M_employee::getAllData');
$routes->get($parent.'/getDataModal', 'M_employee::getDataModal');
$routes->post($parent.'/getData', 'M_employee::getData');

$parent = '/tdisasteroccurimpact';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurimpact::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_disasteroccurimpact::add/$1');
$routes->post($parent.'/addsave', 'T_disasteroccurimpact::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasteroccurimpact::edit/$1');
$routes->post($parent.'/editsave', 'T_disasteroccurimpact::editsave');
$routes->post($parent.'/delete', 'T_disasteroccurimpact::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_disasteroccurimpact::getAllData/$1');
$routes->get($parent.'/getDataModal', 'T_disasteroccurimpact::getDataModal');
$routes->post($parent.'/getData', 'T_disasteroccurimpact::getData');

$parent = '/tdisasteroccurvictim';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurvictim::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_disasteroccurvictim::add/$1');
$routes->post($parent.'/addsave', 'T_disasteroccurvictim::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasteroccurvictim::edit/$1');
$routes->post($parent.'/editsave', 'T_disasteroccurvictim::editsave');
$routes->post($parent.'/delete', 'T_disasteroccurvictim::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_disasteroccurvictim::getAllData/$1');
$routes->get($parent.'/getDataModal', 'T_disasteroccurvictim::getDataModal');
$routes->post($parent.'/getData', 'T_disasteroccurvictim::getData');

$parent = '/tdisasteroccurbuilding';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurbuilding::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_disasteroccurbuilding::add/$1');
$routes->post($parent.'/addsave', 'T_disasteroccurbuilding::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasteroccurbuilding::edit/$1');
$routes->post($parent.'/editsave', 'T_disasteroccurbuilding::editsave');
$routes->post($parent.'/delete', 'T_disasteroccurbuilding::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_disasteroccurbuilding::getAllData/$1');
$routes->get($parent.'/getDataModal', 'T_disasteroccurbuilding::getDataModal');
$routes->post($parent.'/getData', 'T_disasteroccurbuilding::getData');

$parent = '/tdisasteroccurlogistic';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasteroccurlogistic::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_disasteroccurlogistic::add/$1');
$routes->post($parent.'/addsave', 'T_disasteroccurlogistic::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasteroccurlogistic::edit/$1');
$routes->post($parent.'/editsave', 'T_disasteroccurlogistic::editsave');
$routes->post($parent.'/delete', 'T_disasteroccurlogistic::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_disasteroccurlogistic::getAllData/$1');
$routes->get($parent.'/getDataModal', 'T_disasteroccurlogistic::getDataModal');
$routes->post($parent.'/getData', 'T_disasteroccurlogistic::getData');

$parent = '/mearlywarning';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_earlywarning::index');
});
$routes->get($parent.'/add', 'M_earlywarning::add');
$routes->post($parent.'/addsave', 'M_earlywarning::addsave');
$routes->get($parent.'/edit/(:num)', 'M_earlywarning::edit/$1');
$routes->post($parent.'/editsave', 'M_earlywarning::editsave');
$routes->post($parent.'/delete', 'M_earlywarning::delete');
$routes->get($parent.'/getAllData', 'M_earlywarning::getAllData');
$routes->get($parent.'/getDataModal', 'M_earlywarning::getDataModal');
$routes->post($parent.'/getData', 'M_earlywarning::getData');

$parent = '/tinoutitem';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_inoutitem::index');
});
$routes->get($parent.'/add', 'T_inoutitem::add');
$routes->post($parent.'/addsave', 'T_inoutitem::addsave');
$routes->get($parent.'/edit/(:num)', 'T_inoutitem::edit/$1');
$routes->post($parent.'/editsave', 'T_inoutitem::editsave');;
$routes->get($parent.'/copy/(:num)', 'T_inoutitem::copy/$1');
$routes->post($parent.'/delete', 'T_inoutitem::delete');
$routes->get($parent.'/getAllData', 'T_inoutitem::getAllData');
$routes->get($parent.'/getDataModal', 'T_inoutitem::getDataModal');
$routes->post($parent.'/getData', 'T_inoutitem::getData');
$routes->post($parent.'/getDataById', 'T_inoutitem::getDataById');


$parent = '/tinoutitemdetail';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_inoutitemdetail::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_inoutitemdetail::add/$1');
$routes->post($parent.'/addsave', 'T_inoutitemdetail::addsave');
$routes->get($parent.'/edit/(:num)', 'T_inoutitemdetail::edit/$1');
$routes->post($parent.'/editsave', 'T_inoutitemdetail::editsave');
$routes->post($parent.'/delete', 'T_inoutitemdetail::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_inoutitemdetail::getAllData/$1');
$routes->get($parent.'/getDataModal/(:num)', 'T_inoutitemdetail::getDataModal/$1');
$routes->post($parent.'/getData', 'T_inoutitemdetail::getData');
$routes->post($parent.'/getDataById', 'T_inoutitemdetail::getDataById');

$parent = '/setting';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'M_form::index');
});
$routes->post($parent.'/savedisasterreport', 'M_form::savedisasterreport');
$routes->post($parent.'/savedisasteroccur', 'M_form::savedisasteroccur');
$routes->post($parent.'/saveinoutitem', 'M_form::saveinoutitem');
$routes->post($parent.'/saveuserlocation', 'M_form::saveuserlocation');
$routes->post($parent.'/saveimpactcompensation', 'M_form::saveimpactcompensation');


$parent = '/tdisasterassessment';
$routes->group($parent, function ($routes) {
    $routes->get('/', 'T_disasterassessment::index');
});
$routes->get($parent.'/add', 'T_disasterassessment::add');
$routes->post($parent.'/addsave', 'T_disasterassessment::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasterassessment::edit/$1');
$routes->post($parent.'/editsave', 'T_disasterassessment::editsave');
$routes->post($parent.'/delete', 'T_disasterassessment::delete');
$routes->get($parent.'/getAllData', 'T_disasterassessment::getAllData');
$routes->get($parent.'/getDataModal', 'T_disasterassessment::getDataModal');
$routes->post($parent.'/getData', 'T_disasterassessment::getData');
$routes->post($parent.'/getDataById', 'T_disasterassessment::getDataById');



$parent = '/tdisasterassessmentimpact';
$routes->group($parent, function ($routes) {
    $routes->get('/(:num)', 'T_disasterassessmentimpact::index/$1');
});
$routes->get($parent.'/add/(:num)', 'T_disasterassessmentimpact::add/$1');
$routes->post($parent.'/addsave', 'T_disasterassessmentimpact::addsave');
$routes->get($parent.'/edit/(:num)', 'T_disasterassessmentimpact::edit/$1');
$routes->post($parent.'/editsave', 'T_disasterassessmentimpact::editsave');
$routes->post($parent.'/delete', 'T_disasterassessmentimpact::delete');
$routes->get($parent.'/getAllData/(:num)', 'T_disasterassessmentimpact::getAllData/$1');
$routes->get($parent.'/getDataModal', 'T_disasterassessmentimpact::getDataModal');
$routes->post($parent.'/getData', 'T_disasterassessmentimpact::getData');

// /**
//  * Reports
//  */
// $routes->group('/report', function ($routes) {
//     $routes->group('/disaster', function ($routes) {

//         $routes->get($parent.'/', 'Reports\R_Disaster::viewdisaster');
//         $routes->post($parent.'/print', 'Reports\R_Disaster::printreport');
//     });


//     $routes->group('/population', function ($routes) {

//         $routes->get($parent.'/', 'Reports\R_Population::viewpopulation');
//         $routes->post($parent.'/print', 'Reports\R_Population::printreport');
//     });


//     $routes->group('/inoutitem', function ($routes) {

//         $routes->get($parent.'/', 'Reports\R_Inoutitem::viewinoutitem');
//         $routes->post($parent.'/print', 'Reports\R_Inoutitem::printreport');
//     });
// });
// /** End reports */
// $routes->get($parent.'/test', 'Test::index');
// $routes->get($parent.'/testsave', 'Test::testsave');
// $routes->get($parent.'/datatableGet', 'Test::datatableGet');
// $routes->get($parent.'/gettest', 'Test::gettest');
// $routes->post($parent.'/submittest', 'Test::submittest');

// // $routes->controller('/contact', 'App\Controller\Contact');
// //REST api
// $routes->group('/api', function ($routes) {
//     $routes->get($parent.'/login/(:num)/(:num)', 'Rests\User::login');
//     $routes->get($parent.'/company', 'Rests\Company::getCompany');

//     $routes->group('/foods', function ($routes) {
//         $routes->get($parent.'/getfoods', 'Rests\ApiFoods::getfoods');
//         $routes->get($parent.'/getfoodbyid/(:num)', 'Rests\ApiFoods::getfoodbyid');
//     });

//     $routes->group('/province', function ($routes) {
//         $routes->get($parent.'/getprovinces', 'Rests\ApiMProvince::getProvince');
//         $routes->post($parent.'/postprovinces', 'Rests\ApiMProvince::postProvince');
//         $routes->put('/putprovinces', 'Rests\ApiMProvince::putProvince');
//         $routes->delete('/deleteprovinces/(:num)', 'Rests\ApiMProvince::deleteProvince');
//     });

//     $routes->group('/user', function ($routes) {
//         $routes->get($parent.'/login/(:num)/(:num)', 'Rests\User::login');
//         $routes->post($parent.'/createuserlocation', 'Rests\User::postUserLocation');
//         $routes->get($parent.'/userlocation', 'Rests\User::getUserLocation');
//         $routes->put('/startmoving', 'Rests\User::startMoving');
//     });

//     $routes->group('/disasteroccur', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\DisasterOccur::getDisasterOccurs');
//         $routes->get($parent.'/detail/(:num)', 'Rests\DisasterOccur::getDisasteOccurById');
//         $routes->post($parent.'/create', 'Rests\DisasterOccur::postDisasterOccur');
//         $routes->get($parent.'/victims/(:num)', 'Rests\DisasterOccurVictim::getDisasterOccurVictims');
//         $routes->get($parent.'/impacts/(:num)', 'Rests\DisasterOccurImpact::getDisasterOccurImpacts');
//         $routes->get($parent.'/buildings/(:num)', 'Rests\DisasterOccurBuilding::getDisasterOccurBuildings');
//         $routes->post($parent.'/victim/create', 'Rests\DisasterOccurVictim::postDisasterOccurVictim');
//         $routes->delete('/victim/delete/(:num)', 'Rests\DisasterOccurVictim::deleteVictim');
//         $routes->post($parent.'/building/create', 'Rests\DisasterOccurBuilding::postDisasterOccurBuilding');
//         $routes->delete('/building/delete/(:num)', 'Rests\DisasterOccurBuilding::deleteBuilding');
//         $routes->post($parent.'/impact/create', 'Rests\DisasterOccurImpact::postDisasterOccurImpact');
//         $routes->delete('/impact/delete/(:num)', 'Rests\DisasterOccurImpact::deleteImpact');
//         $routes->put('/handle', 'Rests\DisasterOccur::handle');
//     });

//     $routes->group('/disasterreport', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\DisasterReport::getDisasterReports');
//         $routes->get($parent.'/detail/(:num)', 'Rests\DisasterReport::getDisasterReportById');
//         $routes->get($parent.'/listbyphone/(:num)', 'Rests\DisasterReport::getDisasterReportsByPhone');
//         $routes->get($parent.'/report/(:num)', 'Rests\DisasterReport::getDisasterReportsByNo');
//         $routes->post($parent.'/create', 'Rests\DisasterReport::postDisasterReport');
//         $routes->post($parent.'/actualReport', 'Rests\DisasterReport::postActualReport');
//         $routes->put('/handle', 'Rests\DisasterReport::handle');
//         $routes->delete('/delete/(:num)', 'Rests\DisasterReport::deleteDisasterReport');
//     });

    

//     $routes->group('/familycard', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\FamilyCard::getFamilyCard');
//         $routes->get($parent.'/members', 'Rests\FamilyCard::getFamilyCardMember');
//         $routes->get($parent.'/member/(:num)', 'Rests\FamilyCard::getFamilyCardMemberById');
//         $routes->get($parent.'/indisasteroccur/(:num)', 'Rests\FamilyCard::getFamilyCardInOccur');
//     });

//     $routes->group('/disaster', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\Disaster::getDisasters');
//     });

    
//     $routes->group('/pocketbook', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\PocketBook::getPocketbooks');
//     });

//     $routes->group('/public', function ($routes) {
//         $routes->get($parent.'/register/(:num)', 'Rests\Reporter::registerPhone');
//         $routes->post($parent.'/verify', 'Rests\Reporter::verify');
//     });

//     $routes->group('/broadcast', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\Broadcast::getBroadcasts');
//         $routes->get($parent.'/detail/(:num)', 'Rests\Broadcast::getBroadcastById');
//     });

//     $routes->group('/subvillage', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\Subvillage::getSubvillages');
//     });

//     $routes->group('/impact', function ($routes) {
//         $routes->get($parent.'/list', 'Rests\Impact::getImpacts');
//     });
// });


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
