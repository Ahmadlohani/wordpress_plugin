<?php

// Dircet Checkout for woocommerce

add_filter('add_to_cart_redirect', 'lw_add_to_cart_redirect');

function lw_add_to_cart_redirect() {

 global $woocommerce;
 $lw_redirect_checkout = $woocommerce->cart->get_checkout_url();
 return $lw_redirect_checkout;

}

add_filter( 'woocommerce_product_add_to_cart_text', 'lw_cart_btn_text' );

//Changing Add to Cart text to Buy Now! 

function lw_cart_btn_text() {

 return __( 'Buy Now', 'woocommerce' );

}
