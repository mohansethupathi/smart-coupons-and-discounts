<?php

namespace App\Controllers;

if( ! defined('ABSPATH') ) exit();

class Checkcoupon
{

	public function checkAndAddCouponToCart()
	{		
    	 if (isset($_GET['apply_coupon'])) 
    	 {	
        	 $coupon_code = sanitize_text_field($_GET['apply_coupon']);
			
			 if ($this->isCouponApplied($coupon_code)) {

				return false;

			}
        
			 if(!add_filter('woocommerce_coupon_is_valid', array( $this, 'checkCouponDataField'), 10, 2 ))
        	 {
        	 	wc_add_notice('Coupon is not valid.', 'error');
        	 }
			
       	 	// Apply the coupon to the cart
         	if (WC()->cart->apply_coupon($coupon_code)) {
				   $cart_page_url = wc_get_cart_url();
				   wp_safe_redirect($cart_page_url);
				   exit();
        	} 
   		 }

	}

	public function isCouponApplied($coupon_code) {
		// Get the cart object
		$cart = WC()->cart;
		
		// Get the applied coupons
		$applied_coupons = $cart->getAppliedCoupons();
		
		// Check if the coupon code is in the list of applied coupons
		return in_array($coupon_code, $applied_coupons);
	}

	public function checkCouponDataField($valid, $coupon)
	{
         // Check if the coupon data field exists
   		 $custom_data_field = $coupon->get_meta('custom_coupon_field');
		
   		 if ($custom_data_field !== '1') {
        	 // Set the coupon as invalid
       		 $valid = false;
        	// wc_add_notice('Coupon cannot be applied due to invalid data field.', 'error');
  		 }

   		 return $valid;
	}

	
    public function getCouponIncludeUserRolesOnAddToCart($valid,$coupon_code)
    {
		$coupon_code = $coupon_code->code;
    	$coupon_id = wc_get_coupon_id_by_code($coupon_code);
		
    	$check_first_order = $this->preventCouponApplied($coupon_id);
		
    	if($check_first_order) return false;
		
  		if ( empty( $coupon_id ) ) return false;
		
        $include_user_roles = get_post_meta($coupon_id, 'includeuser', true);
        $exclude_user_roles = get_post_meta($coupon_id, 'excludeuser', true);
		
        if (empty($include_user_roles) && empty($exclude_user_roles)) return true;
			
        $current_user_list = wp_get_current_user();
		
        if (isset($current_user_list->roles) && is_array($current_user_list->roles)) {
        $current_user = $current_user_list->roles[0]; 
   		}
           
        $include_user_roles_inarray = explode( ' , ' , $include_user_roles );
        $exclude_user_roles_inarray = explode( ' , ' , $exclude_user_roles );
		
        if ( !in_array( ($current_user), $include_user_roles_inarray) && !in_array( ($current_user), $exclude_user_roles_inarray) ) 
        return true;

     	if ( in_array( ($current_user), $include_user_roles_inarray) && !in_array( ($current_user), $exclude_user_roles_inarray) ) 

        return true;

     	if ( !in_array( ($current_user), $include_user_roles_inarray) && in_array( ($current_user), $exclude_user_roles_inarray) ) 
     	wc_add_notice('Coupon cannot be applied due to User Restriction.', 'error');
        return false;

     	if ( in_array( ($current_user), $include_user_roles_inarray) && in_array( ($current_user), $exclude_user_roles_inarray) ) 

        return true;

	}

	
	public function getCustomCouponData($coupon_code)
	{
   
       $coupon_id = wc_get_coupon_id_by_code($coupon_code);

       if ($coupon_id) {
        
        $custom_data = get_post_meta($coupon_id, 'custom_coupon_data', true);

        return $custom_data;
        }

  	    return false; // Coupon not found or custom data not set
	}


	public function preventCouponApplied($coupon_id)
	{

		$filtered_value = $this->checkCustomFirstOrder($coupon_id);
		
		if ($filtered_value == '1') {
			$first_purchase = $this->isFirstPurchase();
			
			if($first_purchase !== 0)
			{
				return true;
			}

			return false;
		}

		return false;

	}

	public function checkCustomFirstOrder($coupon_id)
	{		
		if ($coupon_id) {
        $custom_data = get_post_meta($coupon_id, 'custom_first_order', true);
        return $custom_data;
   		}

        return false;
	}

	public function isFirstPurchase()
	{
		
	    $user_id = get_current_user_id();

	    if ($user_id) {

	        $orders = wc_get_orders(array(
	            'customer' => $user_id,
	            'status'   => array('completed', 'processing'),
	        ));

	        return count($orders) === 0;
	    }

	    return "Userid Not Found";
	}

	public function runFunctionAfterCouponApplied($coupon_code)
	{
		$coupon_id = wc_get_coupon_id_by_code($coupon_code);

        $free_products_data = get_post_meta($coupon_id, 'freeproducts', true);

		if ($free_products_data) {

			$free_products = explode(' , ', $free_products_data);

			foreach ($free_products as $free_product_id) {
				$is_product_in_cart = false;

				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					if ($cart_item['product_id'] == $free_product_id) {
						$is_product_in_cart = true;
						break;
					}
				}

				// If the free product is not in the cart, add it
				if (!$is_product_in_cart) {

					WC()->cart->add_to_cart($free_product_id, 1, 0, array(), array( 'free_price' => 0 ) );
					
				}
			}
		}
	}

		// Set free price from custom cart item data
	public function actionWoocommerceBeforeCalculateTotals( $cart ) {
		
		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;

		// Loop through cart contents
		foreach ( $cart->get_cart_contents() as $cart_item ) {       
			if ( isset( $cart_item['free_price'] ) ) {
				$cart_item['data']->set_price( $cart_item['free_price'] );
			}
		}
	}

	public function getRemovedCouponCode($coupon_code) {

		$coupon_id = wc_get_coupon_id_by_code($coupon_code);

        $free_products_data = get_post_meta($coupon_id, 'freeproducts', true);

		if ($free_products_data) {

			$free_products = explode(' , ', $free_products_data);

			foreach ($free_products as $free_product_id) {
				
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					if ($cart_item['product_id'] == $free_product_id) {
						WC()->cart->remove_cart_item($cart_item_key);
					}
				}

			}
		}
	}
}