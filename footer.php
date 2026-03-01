<?php

/**
 * The template for displaying the footer.
 */

?>

<?php
// Get company name from contact settings or fallback to old field
$company_name = get_field('contact_company_name', 'option') ?: get_field('name', 'option');

// Get page-specific CSS and scripts
$page_custom_css = get_field('page_custom_css');
$lower1199 = get_field('lower1199');
$lower767 = get_field('lower767');
$page_footer_scripts = get_field('page_footer_scripts');
?>

<div class="container-fluid">
	<div class="footerfluid2">
		<div class="container">
			<p>Copyright &copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html($company_name); ?> - Website Powered by <a style="font-weight:600;color:white;text-decoration:none;" target="_blank" href="https://thedevq.com/">DevQ</a></p>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		AOS.init();
	});
</script>

<?php wp_footer(); ?>

<?php
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