<?php /** @noinspection PhpUndefinedConstantInspection */

namespace App\Controllers;

if( ! defined('ABSPATH') ) exit();

class Coupon
{

    public function customCouponField($coupon)
    {
        global $custom_field_value; // Access the data variable
        global $couponlink; // Access the data variable

        $custom_field_value = get_post_meta($coupon, 'custom_coupon_field', true);
        $couponlink = get_post_meta($coupon, 'couponlink', true);

        // Load the view file and pass data to it
        include( WP_PLUGIN_DIR . "/smartcoupons/App/Views/urlcoupons.php");

    }

    public function saveCustomCouponField($post_id)
    {
        if (isset($_POST['custom_coupon_field'])) {
            update_post_meta($post_id, 'custom_coupon_field', '1');
        } else {
            delete_post_meta($post_id, 'custom_coupon_field');
        }

        if (isset($_POST['couponlink'])) {
            update_post_meta($post_id, 'couponlink', $_POST['couponlink']);
        } else {
            delete_post_meta($post_id, 'custom_coupon_field');
        }

        $this->saveCustomFirstOrder($post_id);

    }


    public function saveCustomFirstOrder($post_id)
    {
        if (isset($_POST['custom_first_order'])) {
            update_post_meta($post_id, 'custom_first_order', '1');
        } else {
            delete_post_meta($post_id, 'custom_first_order');
        }

        $this->saveIncludeUserRoleData($post_id);

    }

    // Save include user role data
    public function saveIncludeUserRoleData($post_id) {

        $implode_user_role = isset($_POST['includeuser']) ? implode(" , ", $_POST['includeuser']) : '';
        $include_user_role = sanitize_text_field($implode_user_role);
        update_post_meta($post_id, 'includeuser', $include_user_role);

        $this->saveExcludeUserRoleData($post_id);
    }

    // Save exclude user role data
    public function saveExcludeUserRoleData($post_id) {

        $implode_user_role = isset($_POST['excludeuser']) ? implode(" , ", $_POST['excludeuser']) : '';
        $exclude_user_role = sanitize_text_field($implode_user_role);
        update_post_meta($post_id, 'excludeuser', $exclude_user_role);

        $this->saveAddFreeProductsData($post_id);
    }

    // Save addfree products data
    public function saveAddFreeProductsData($post_id) {

        $addfree_products = isset($_POST['freeproducts']) ? implode(" , ", $_POST['freeproducts']) : '';
        $addfree_products = sanitize_text_field($addfree_products);
        update_post_meta($post_id, 'freeproducts', $addfree_products);

    }

    // Add a custom select box
    public function addCustomSelectBox($coupon) {
        global $post;

        if ($post && $post->post_type == 'shop_coupon') {

            $custom_first_order = get_post_meta($coupon, 'custom_first_order', true);
            $saved_include_user_role = get_post_meta($coupon, 'includeuser', true);
            $saved_exclude_user_role = get_post_meta($coupon, 'excludeuser', true);

            // Load the view file and pass data to it
            include( WP_PLUGIN_DIR . "/smartcoupons/App/Views/usagerestriction.php");

        }
    }

    public function customCouponDataTabs($tabs)
    {
        $tabs['custom_tab'] = array(
            'label'    => __('Add Free Products', 'text-domain'), // Label for the tab
            'target'   => 'custom_coupon_tab', // Tab target (HTML ID)
            'priority' => 80, // Priority of the tab
        );

        return $tabs;
    }

    public function customCouponDataPanel($coupon)
    {
        global $post;

        if ($post && $post->post_type == 'shop_coupon') {

            $addfree_products = get_post_meta($coupon, 'freeproducts', true);

            // Load the view file and pass data to it
            include( WP_PLUGIN_DIR . "/smartcoupons/App/Views/addfreeproducts.php");

        }
    }

}