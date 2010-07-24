<?php
/*
Plugin Name: wp-wikify
Plugin URI: http://github.com/mountain/wp-wikify
Description: Make Wikipedia links for keywords
Version: 0.0.1
Author: Mingli Yuan
Author URI: http://www.mingli-yuan.info/
License: GPL2
*/
?>
<?php
function wikify_install() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
  wp_enqueue_script('wikify', WP_PLUGIN_URL . '/wp-wikify/js/jq-wikify.js', array('jquery'));
}

add_action('init', 'wikify_install');

function wikify($post_id, $html_id = '', $keywords = '', $lang = '', $variant = '') {
  $post_keywords = get_post_meta($post_id, 'wikipedia-keywords', 'true');
  $post_lang = get_post_meta($post_id, 'wikipedia-lang', 'true');
  $post_variant = get_post_meta($post_id, 'wikipedia-variant', 'true');

  if (!empty( $post_keywords )) $keywords = $post_keywords;
  if (!empty( $post_lang )) $lang = $post_lang;
  if (!empty( $post_variant )) $variant = $post_variant;

  if(is_array($keywords)) {
    $array = $keywords;
  } else {
    $array = explode(",",  $keywords);
  }

  $keywords = '[';
  foreach($array as $value) {
    $keywords .= ('"'.$value.'", ');
  }
  $keywords .= ']';

  $return = '<script type="text/javascript" charset="utf-8">$(function() { $("'.$html_id.'").wikify('.$keywords.',"'.$lang.'","'.$variant.'"); });</script>';

  return $return;
}
?>

