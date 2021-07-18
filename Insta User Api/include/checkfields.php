<?php 

include plugin_dir_path( __FILE__ ). "setmetavariables.php";
include plugin_dir_path( __FILE__ ). "setitemmeta.php";
include plugin_dir_path( __FILE__ ). "direct_checkout.php";

add_action( "admin_enqueue_scripts", "enqueueStyle") ;
function enqueueStyle(){
    wp_enqueue_style( 'custom', PLUGIN_URL . './assets/css/customcheckout.css');
}

// Changing placeholder of email field

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_email']['placeholder'] = 'Email here';
     return $fields;
}
 // Adding a new div for images
add_action( 'woocommerce_after_checkout_billing_form', 'add_div');

function add_div(){
    echo '<div id="insta_posts"></div>';
    echo '<div id="loading_posts"></div>';
}

// Conditional billing field
add_action( 'woocommerce_billing_fields', 'woo_add_conditional_billing_fields' );

function woo_add_conditional_billing_fields( $fields ) {

	if( WC()->cart->get_cart()){
        $item = WC()->cart->get_cart();
        $len = sizeof($item);
        $keys = array_keys($item);
        $lastKey = $keys[$len-1];
        // echo "<pre>";print_r($keys[$len-1]);echo "</pre>";
        if (empty($item[$lastKey]["instagram_data"])) {
            $fields['billing_insta_user'] = array(
                'label'     => __('Instagram Username ', 'woocommerce'),
                'placeholder'   => _x('Username here ', 'placeholder', 'woocommerce'),
                'required'  => true,
                'class'     => array('form-row-wide'),
                'clear'     => true
            );
        }else {
            unset( $fields['billing']['billing_insta_user'] );
        }
	// Return checkout fields.
	return $fields;
    }
}

// Code for resetting Checkout values

add_filter('woocommerce_checkout_get_value','__return_empty_string',10);

// Code for removing unnecessary billing fields

function wc_remove_checkout_fields( $fields ) {

    // Billing fields
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_phone'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_first_name'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );

    // Shipping fields
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_country'] );
    unset( $fields['shipping']['shipping_phone'] );
    unset( $fields['shipping']['shipping_state'] );
    unset( $fields['shipping']['shipping_first_name'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_address_1'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_city'] );
    unset( $fields['shipping']['shipping_postcode'] );

    // Order fields
    unset( $fields['order']['order_comments'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );