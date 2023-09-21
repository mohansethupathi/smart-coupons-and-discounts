<?php

namespace App;
use \App\Controllers;

if( ! defined('ABSPATH') ) exit();

class Routes
{
    private static $coupon, $enqueue, $check_coupon;

    public function init()
    {
        self::$coupon = empty( self::$coupon ) ? new \App\Controllers\Coupon() : self::$coupon;
        self::$enqueue = empty( self::$enqueue ) ? new \App\Controllers\Enqueue() : self::$enqueue;
        self::$check_coupon = empty( self::$check_coupon ) ? new \App\Controllers\Checkcoupon() : self::$check_coupon;

        add_action( 'init', array( self::$check_coupon, 'checkAndAddCouponToCart' ) );
        add_action( 'woocommerce_coupon_options', array( self::$coupon, 'customCouponField' ) );
        add_action( 'woocommerce_coupon_options_save', array( self::$coupon, 'saveCustomCouponField' ) );
        add_action( 'woocommerce_coupon_options_usage_restriction', array( self::$coupon, 'addCustomSelectBox' ) );
        add_filter( 'woocommerce_coupon_is_valid', array( self::$check_coupon, 'getCouponIncludeUserRolesOnAddToCart'), 10, 2);
        add_action( 'woocommerce_applied_coupon', array( self::$check_coupon, 'runFunctionAfterCouponApplied') );
        add_action( 'woocommerce_before_calculate_totals', array( self::$check_coupon, 'actionWoocommerceBeforeCalculateTotals'), 10, 1 );
        add_filter( 'woocommerce_coupon_data_tabs', array( self::$coupon, 'customCouponDataTabs') );
        add_action( 'woocommerce_coupon_data_panels', array( self::$coupon, 'customCouponDataPanel') );
        add_action( 'admin_enqueue_scripts',array( self::$enqueue, 'enqueueList'));
        add_action( 'woocommerce_removed_coupon', array( self::$check_coupon, 'getRemovedCouponCode'), 10, 1);

    }
}
