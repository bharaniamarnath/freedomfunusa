<?php

require_once __DIR__.'/application/router.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index

// Freedom Fun

get('/', 'views/home.php');
get('/home', 'views/home.php');
get('/about', 'views/about.php');
get('/faq', 'views/faq.php');
get('/privacy', 'views/privacy.php');
get('/terms', 'views/terms.php');
get('/contact', 'views/contact.php');
get('/waiver', 'views/waiver.php');

//NO JS
get('/error/javascript', 'views/nojs.php');

//Administrator
get('/admin', 'views/admin/login.php');
get('/admin/register', 'views/admin/register.php');
get('/admin/login', 'views/admin/login.php');
get('/admin/logout', 'views/admin/logout.php');
get('/admin/dashboard', 'views/admin/dashboard.php');
get('/admin/manage', 'views/admin/manage.php');
get('/admin/statistics', 'views/admin/statistics.php');
get('/admin/profile', 'views/admin/profile.php');
get('/admin/settings', 'views/admin/settings.php');

//Administrator - Categories
get('/admin/category/register', 'views/admin/category/register.php');
get('/admin/category/list', 'views/admin/category/list.php');
get('/admin/category/edit/$category_id', 'views/admin/category/edit.php');

//Administrator - Events
get('/admin/event/register', 'views/admin/event/register.php');
get('/admin/event/list', 'views/admin/event/list.php');
get('/admin/event/edit/$event_id', 'views/admin/event/edit.php');

//Administrator - Event Orders
get('/admin/event/order/list', 'views/admin/event/order/list.php');
get('/admin/event/order/view/$event_id', 'views/admin/event/order/view.php');

//Administrator - Games
get('/admin/game/register', 'views/admin/game/register.php');
get('/admin/game/list', 'views/admin/game/list.php');
get('/admin/game/edit/$game_id', 'views/admin/game/edit.php');

//Administrator - Freeplay
get('/admin/freeplay/list', 'views/admin/freeplay/list.php');
get('/admin/freeplay/view/$freeplay_id', 'views/admin/freeplay/view.php');

//Administrator - Walk-In
get('/admin/signup/event', 'views/admin/signup/event.php');
get('/admin/signup/list/$event_id', 'views/admin/signup/list.php');
get('/admin/signup/game/$event_game_id', 'views/admin/signup/game.php');
get('/admin/signup/cart', 'views/admin/signup/cart.php');
get('/admin/signup/participant', 'views/admin/signup/participant.php');
get('/admin/signup/checkout', 'views/admin/signup/checkout.php');
get('/admin/signup/billing', 'views/admin/signup/billing.php');
get('/admin/signup/payment/card', 'views//admin/signup/payment/card.php');
get('/admin/signup/payment/cash', 'views//admin/signup/payment/cash.php');
get('/admin/signup/payment/success', 'views//admin/signup/payment/success.php');
get('/admin/signup/payment/failed', 'views//admin/signup/payment/failed.php');
get('/admin/signup/payment/error', 'views//admin/signup/payment/error.php');


//Administrator - Event Games
get('/admin/event/$event_id/game/register', 'views/admin/event/game/register.php');
get('/admin/event/$event_id/game/edit/$event_game_id', 'views/admin/event/game/edit.php');

//Freeplay
get('/freeplay/register', 'views/freeplay/register.php');
get('/freeplay/waiver', 'controllers/freeplay/freeplay_waiver.php');

//Event - Categories
get('/event/list', 'views/event/list/list.php');
get('/event/categories/$event_id', 'views/event/list/category.php');

//Event - Single

get('/event/view/$event_id', 'views/event/detail/event.php');
get('/event/game/view/$event_game_id', 'views/event/detail/game.php');
get('/event/category/view/$category_id', 'views/event/detail/category.php');

get('/event/token/view/$event_game_id', 'views/event/detail/token.php');
get('/event/wristband/view/$event_game_id', 'views/event/detail/wristband.php');

//Event - Cart
get('/event/cart', 'views/event/cart.php');

//Event - Participant
get('/event/participant', 'views/event/participant/account.php');
get('/event/participant/dashboard', 'views/event/participant/dashboard.php');
get('/event/participant/logout', 'views/event/participant/logout.php');

//Fund - Checkout
get('/event/checkout', 'views/event/checkout.php');

//Event - Billing
get('/event/billing', 'views/event/billing.php');

//Event - Payment
get('/event/payment/card', 'views/event/payment/card.php');

get('/event/payment/success', 'views/event/payment/success.php');
get('/event/payment/failed', 'views/event/payment/failed.php');
get('/event/payment/error', 'views/event/payment/error.php');


get('/get_oauth_token', 'views/oauth.php');
get('/sendmail', 'views/sendmail.php');

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');
get('/person/name/$name/age/$age', 'views/person');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// POST Routes

//Admin
post('/admin/register', 'controllers/administrator/admin/admin_register.php');
post('/admin/login', 'controllers/administrator/admin/admin_login.php');
post('/admin/profile/edit', 'controllers/administrator/admin/admin_edit.php');
post('/admin/password/edit', 'controllers/administrator/admin/admin_password.php');
post('/admin/config/about/edit', 'controllers/administrator/configure/config_about.php');
post('/admin/config/constant/edit', 'controllers/administrator/configure/config_constant.php');

//Admin - Administrator
post('/admin/administrator/list', 'views/admin/administrator/list.php');
post('/admin/administrator/edit', 'controllers/administrator/admin/admin_edit.php');

//Admin - Categories
post('/admin/category/register', 'controllers/administrator/category/category_register.php');
post('/admin/category/edit', 'controllers/administrator/category/category_edit.php');
post('/admin/category/delete', 'controllers/administrator/category/category_delete.php');

//Admin - Events
post('/admin/event/register', 'controllers/administrator/event/event_register.php');
post('/admin/event/edit', 'controllers/administrator/event/event_edit.php');
post('/admin/event/delete', 'controllers/administrator/event/event_delete.php');
post('/admin/event/list', 'views/admin/event/list.php');

//Admin - Games
post('/admin/game/register', 'controllers/administrator/game/game_register.php');
post('/admin/game/edit', 'controllers/administrator/game/game_edit.php');
post('/admin/game/delete', 'controllers/administrator/game/game_delete.php');
post('/admin/game/list', 'views/admin/game/list.php');

//Admin - Event Games
post('/admin/event/game/register', 'controllers/administrator/event/game/event_game_register.php');
post('/admin/event/game/edit', 'controllers/administrator/event/game/event_game_edit.php');
post('/admin/event/game/delete', 'controllers/administrator/event/game/event_game_delete.php');

//Admin - Event Orders
post('/admin/event/order/list', 'views/admin/event/order/list.php');

//Admin - Event Participants
post('/admin/event/checkin', 'controllers/administrator/event/participant/event_checkin.php');

//Freeplay
post('/freeplay/register', 'controllers/freeplay/freeplay_register.php');
post('/admin/freeplay/list', 'views/admin/freeplay/list.php');

//Event
post('/event/add', 'controllers/event/event_add.php');
post('/event/update', 'controllers/event/event_update.php');
post('/event/remove', 'controllers/event/event_remove.php');
post('/event/checkout', 'controllers/event/event_checkout.php');
post('/event/billing', 'controllers/event/event_billing.php');

//Participant
post('/event/participant/register', 'controllers/participant/participant_register.php');
post('/event/participant/login', 'controllers/participant/participant_login.php');

//Walk-In
post('/admin/signup/event/add', 'controllers/signup/event_add.php');
post('/admin/signup/event/remove', 'controllers/signup/event_remove.php');
post('/admin/signup/participant', 'controllers/signup/event_participant.php');
post('/admin/signup/checkout', 'controllers/signup/event_checkout.php');
post('/admin/signup/billing', 'controllers/signup/event_billing.php');

//Payment - Walk-In
post('/admin/signup/transaction', 'controllers/signup/event_transaction.php');
post('/admin/signup/reserve', 'controllers/signup/event_reserve.php');


//Payment - Event
post('/event/transaction', 'controllers/event/event_transaction.php');

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');

?>