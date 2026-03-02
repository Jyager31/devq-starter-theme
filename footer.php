<?php

/**
 * The template for displaying the footer.
 */

?>

<?php
// Load the selected footer style
$layout_footer_style = get_field('layout_footer_style', 'option') ?: 'minimal';
get_template_part('template-parts/footer/style', $layout_footer_style);
?>

<script>
	jQuery(document).ready(function($) {
		AOS.init();
	});
</script>

<?php wp_footer(); ?>

<?php
// Get page-specific CSS and scripts
$page_custom_css = get_field('page_custom_css');
$lower1199 = get_field('lower1199');
$lower767 = get_field('lower767');
$page_footer_scripts = get_field('page_footer_scripts');

// Output any additional footer scripts
if ($page_footer_scripts) {
	echo wp_kses_post($page_footer_scripts);
}

// Output page-specific CSS
if ($page_custom_css) :
	echo '<style>';
	echo wp_strip_all_tags($page_custom_css);
	echo '</style>';
endif;

// Output responsive CSS
if ($lower1199) :
	echo '<style> @media (max-width: 1199px) {';
	echo wp_strip_all_tags($lower1199);
	echo '} </style>';
endif;

if ($lower767) :
	echo '<style> @media (max-width: 767px) {';
	echo wp_strip_all_tags($lower767);
	echo '} </style>';
endif;
?>

</body>

</html>
