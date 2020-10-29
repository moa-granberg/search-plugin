<?php
/*
Plugin Name: The Pied Search Miracle
*/

function do_search($searchQuery)
{
  global $wpdb;
  $table_name = $wpdb->prefix . "posts";
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE (post_content LIKE '%$searchQuery%' OR post_title LIKE '%$searchQuery%') AND post_status LIKE 'publish'");
  $searchResult = "";

  foreach ($results as $row) {
    $permalink = get_permalink($row->ID);
    $postContent = substr(wp_strip_all_tags($row->post_content), 0, 22) . '...';

    $searchResult = $searchResult . "<div class='pied-search-result-item'>
      <p><a href='$permalink'>$row->post_title</a></p>
      <p>$postContent</p>
    </div>";
  }

  return "<div class='pied-search-results'>" . $searchResult . "</div>";
}

function get_content($content)
{
  $searchBtn = "<p><a href='index.php?gogosearch=true'><button>Search</button></a></p>";
  $searchInputField = "";
  $searchResult = "";

  if (isset($_GET["gogosearch"])) {
    $searchBtn = '';
    $searchInputField = "
    <form action='' method='POST' class='pied-search-form'>
      <input type='text' placeholder='search...' name='searchQuery' />
      <input value='Search' type='submit'/>
    </form>";

    if (isset($_POST['searchQuery']) && !empty($_POST["searchQuery"])) {
      $searchQuery = $_POST['searchQuery'];
      $searchResult = do_search($searchQuery);
    }
  }

  return $content . $searchBtn . $searchInputField . $searchResult;
}

function setup_scripts() {
  $plugin_url = plugin_dir_url(__FILE__);
  wp_register_style( 'stajling', $plugin_url . '/pied.css' );
  wp_enqueue_style( 'stajling' );
}
add_action('wp_enqueue_scripts', 'setup_scripts');

add_filter('the_content', 'get_content');

