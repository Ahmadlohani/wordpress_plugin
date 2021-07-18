<?php 

// Setting Item meta by taking values from SESSION

add_action( 'woocommerce_add_order_item_meta', 'add_order_item_meta', 10, 2 );
function add_order_item_meta($item_id, $values) {

    $key = "p_insta_detail";
    $userProfileMeta = (!empty($_SESSION["profileMetaVal"])?$_SESSION["profileMetaVal"]:"");
    $userImageMeta = (!empty($_SESSION["imgmetaVal"])?$_SESSION["imgmetaVal"]:"");
    $data = array();
    $data["profile"] = $userProfileMeta;
    $data["post_data"] = $userImageMeta;
    $value = $data;

    wc_update_order_item_meta($item_id,$key,$value); 

}

// For hiding unwanted order item meta

/* add_filter( 'woocommerce_hidden_order_itemmeta', 'hide_order_item_meta_fields' );
 
function hide_order_item_meta_fields( $fields ) {
$fields[] = 'current_view';
$fields[] = 'custom_image';//Add all meta keys to this array,so that it will not be displayed in order meta box
return $fields;
} */

add_action( 'woocommerce_after_order_itemmeta', 'customized_display',10, 3 );

function customized_display($item_id, $item, $null) {
    
    $dt = wc_get_order_item_meta($item_id, "p_insta_detail", true);
    echo "<pre>";print_r($dt);echo"</pre>";
    
}

