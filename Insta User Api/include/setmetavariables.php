<?php

// Action hooks to receive ajax calls

add_action( "wp_ajax_item_meta_action", "item_meta_action_func");
add_action( "wp_ajax_nopriv_item_meta_action", "item_meta_action_func");


add_action( "wp_ajax_image_item_meta_action", "image_item_meta_action_func");
add_action( "wp_ajax_nopriv_image_item_meta_action", "image_item_meta_action_func");


// Getting user posts data from ajax

function item_meta_action_func(){

  $_SESSION["profileMetaVal"] = array();
  if (isset($_POST['action']) && isset($_POST['userdata'])) {

    $_SESSION["profileMetaVal"] = $_POST['userdata'][0];

  }
  print_r( $_SESSION["profileMetaVal"]);
  // echo "Profile meta added successfully";
  wp_die();

}

// Getting images meta from ajax

function image_item_meta_action_func(){

  $_SESSION["imgmetaVal"] = array();
  if (isset($_POST['action']) && isset($_POST['imgmeta'])) {

    $_SESSION["imgmetaVal"] = $_POST['imgmeta'];

  }
  echo "Image meta added successfully";

  wp_die();
}

