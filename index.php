<?php
/*
Plugin Name: The Pied Search Miracle
*/

function do_search($searchQuery)
{
  global $wpdb;
  $table_name = $wpdb->prefix . "posts";
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE (post_content LIKE '%$searchQuery%' OR post_title LIKE '%$searchQuery%') AND post_status LIKE 'publish'");

  foreach ($results as $row) {
    $permalink = get_permalink($row->ID);
    $postContent = substr(wp_strip_all_tags($row->post_content), 0, 22) . '...';

    echo "<p><a href='$permalink'>$row->post_title</a></p>
    <p>Post content: $postContent</p>";
  }
}

function get_content($content)
{
  $searchBtn = "<p><a href='index.php?gogosearch=true'><button>Search...</button></a></p>";
  $searchInputField = "";

  if (isset($_GET["gogosearch"])) {
    $searchBtn = '';
    $searchInputField = "
    <form action='' method='POST'>
      <input type='text' placeholder='search...' name='searchQuery' />
      <input value='Search' type='submit'/>
    </form>";

    if (isset($_POST['searchQuery']) && !empty($_POST["searchQuery"])) {
      $searchQuery = $_POST['searchQuery'];
      do_search($searchQuery);
    }
  }

  return $content . $searchBtn . $searchInputField;
}

add_filter('the_content', 'get_content');
