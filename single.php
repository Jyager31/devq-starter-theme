<?php

/**
 * The template for displaying all single posts.
 */

get_header();

// Load the selected single post style
get_template_part('template-parts/single/style', $layout_single_style);

get_footer();
