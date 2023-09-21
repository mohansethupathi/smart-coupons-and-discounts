<?php
/**
 * Plugin name: Smart Coupons
 * Plugin URI: http://localhost
 * Description:Coupons
 * Author: Mohan
 * Author URI: http://localhost
 * Version: 1.0
 * Slug: Coupons
 * Text Domain: Coupons
 * Domain Path: /i18n/languages/
 * Requires at least: 4.6.1
 * WC requires at least: 3.0
 * WC tested up to: 7.3
 */


if( ! defined('ABSPATH') ) exit();

if(!file_exists( WP_PLUGIN_DIR . '/smartcoupons/vendor/autoload.php' )) return;

require_once WP_PLUGIN_DIR . '/smartcoupons/vendor/autoload.php';

if(!class_exists('App\\Routes')) return;

$routes =  new App\Routes();
$routes->init();

?>