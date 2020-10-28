<?php
/*
Plugin Name: The Pied Search Miracle
*/

function do_search(){
  global $wpdb;
  $table_name = $wpdb->prefix . "posts";
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content LIKE '%första%' AND post_content LIKE '%redigera%'");
  foreach($results as $row){
    error_log("Permalink: " . get_permalink($row->ID) . " Post title: " . $row->post_title . " Post content: " . $row->post_content);
  }
}

add_action('init', 'do_search');