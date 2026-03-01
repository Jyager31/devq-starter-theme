<?php
add_action('init', 'create_posttype');
function create_posttype()
{

  // register_post_type(
  //   'positions',
  //   array(
  //     'labels' => array(
  //       'name' => __('Positions'),
  //       'singular_name' => __('Position'),
  //       'add_new' => 'Add New Position',
  //       'add_new_item' => 'Add New Position',
  //       'edit_item'  => 'Edit Position',
  //       'view_item' => 'View Position'
  //     ),
  //     'menu_icon' => 'dashicons-calendar-alt',
  //     'public' => true,
  //     'has_archive' => true,
  //     'rewrite' => array('slug' => 'available-positions', 'with_front' => false),
  //     'supports' => array('title', 'editor', 'thumbnail'),
  //     'taxonomies' => array('category', 'post_tag') // this is IMPORTANT
  //   )
  // );

}
