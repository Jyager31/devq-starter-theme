<?php

/**
 * The template for displaying archive pages.
 */

get_header();

// Load the selected archive style
get_template_part('template-parts/archive/style', $layout_archive_style);

get_footer();
