<?php
/*
Plugin Name: The Pied Search Miracle
*/

function do_search()
{
  global $wpdb;
  $table_name = $wpdb->prefix . "posts";
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content LIKE '%halloj%' AND post_content LIKE '%världen%'" );
  foreach ($results as $row) {
    error_log("Permalink: " . get_permalink($row->ID) . " Post title: " . $row->post_title . " Post content: " .$row->post_content);
  }
}

function get_content($content) {
  $searchBtn = "<a href='index.php?gogosearch=true'><button>Search...</button></a>";
  $searchInputField = "";

  if(isset($_GET["gogosearch"])) {
    $searchInputField = "<input type='text' placeholder='search...'></input>";
  }

  return $content . $searchBtn . $searchInputField;
}

add_filter('the_content', 'get_content');
