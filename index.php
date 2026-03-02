<?php

/**
 * The main template file.
 */

get_header();

// Load the selected archive style (shared with archive.php)
get_template_part('template-parts/archive/style', $layout_archive_style);

get_footer();
