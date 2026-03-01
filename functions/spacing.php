<?php

/**
 * Centralized Spacing System
 * 
 * This file handles all block spacing logic with desktop/mobile responsive values.
 * Updated mobile breakpoint: 767px (was 991px)
 */

/**
 * Get all spacing values from theme settings
 * 
 * @return array Associative array of spacing values
 */
function get_theme_spacing_values()
{
    return array(
        // Desktop spacing (existing values)
        'small' => get_field('spacing_small', 'option') ?: '20',
        'medium' => get_field('spacing_medium', 'option') ?: '40',
        'large' => get_field('spacing_large', 'option') ?: '80',

        // Mobile spacing (new values)
        'small_mobile' => get_field('spacing_small_mobile', 'option') ?: '15',
        'medium_mobile' => get_field('spacing_medium_mobile', 'option') ?: '25',
        'large_mobile' => get_field('spacing_large_mobile', 'option') ?: '40'
    );
}

/**
 * Generate responsive spacing CSS for a block with unique ID
 * 
 * @param string $margin_top The margin top value (none, small, medium, large, other)
 * @param string $margin_bottom The margin bottom value (none, small, medium, large, other)
 * @param int $margin_top_other Custom margin top value (if margin_top is 'other')
 * @param int $margin_bottom_other Custom margin bottom value (if margin_bottom is 'other')
 * @param string $unique_id The unique ID for the block instance
 * @return string CSS styles for responsive spacing
 */
function generate_block_spacing_css($margin_top, $margin_bottom, $margin_top_other = 0, $margin_bottom_other = 0, $unique_id = '')
{
    $spacing_values = get_theme_spacing_values();
    $css = '';

    // Generate CSS selector using unique ID
    $selector = $unique_id ? '#' . $unique_id : '';

    if (empty($selector)) {
        return $css; // No selector, no CSS
    }

    // Desktop spacing
    $desktop_styles = array();

    // Handle margin top
    if ($margin_top && $margin_top !== 'none') {
        if ($margin_top === 'other') {
            $desktop_styles[] = 'margin-top: ' . intval($margin_top_other) . 'px';
        } else {
            $desktop_styles[] = 'margin-top: ' . $spacing_values[$margin_top] . 'px';
        }
    }

    // Handle margin bottom
    if ($margin_bottom && $margin_bottom !== 'none') {
        if ($margin_bottom === 'other') {
            $desktop_styles[] = 'margin-bottom: ' . intval($margin_bottom_other) . 'px';
        } else {
            $desktop_styles[] = 'margin-bottom: ' . $spacing_values[$margin_bottom] . 'px';
        }
    }

    // Add desktop styles
    if (!empty($desktop_styles)) {
        $css .= $selector . ' { ' . implode('; ', $desktop_styles) . '; }' . "\n";
    }

    // Mobile spacing (767px and below)
    $mobile_styles = array();

    // Handle mobile margin top
    if ($margin_top && $margin_top !== 'none' && $margin_top !== 'other') {
        $mobile_key = $margin_top . '_mobile';
        if (isset($spacing_values[$mobile_key])) {
            $mobile_styles[] = 'margin-top: ' . $spacing_values[$mobile_key] . 'px';
        }
    }

    // Handle mobile margin bottom
    if ($margin_bottom && $margin_bottom !== 'none' && $margin_bottom !== 'other') {
        $mobile_key = $margin_bottom . '_mobile';
        if (isset($spacing_values[$mobile_key])) {
            $mobile_styles[] = 'margin-bottom: ' . $spacing_values[$mobile_key] . 'px';
        }
    }

    // Add mobile styles
    if (!empty($mobile_styles)) {
        $css .= '@media (max-width: 767px) { ' . $selector . ' { ' . implode('; ', $mobile_styles) . '; } }' . "\n";
    }

    return $css;
}

/**
 * Generate inline spacing styles for a block (legacy support)
 * 
 * @param string $margin_top The margin top value
 * @param string $margin_bottom The margin bottom value
 * @param int $margin_top_other Custom margin top value
 * @param int $margin_bottom_other Custom margin bottom value
 * @return string Inline CSS styles (desktop only)
 */
function generate_inline_spacing_styles($margin_top, $margin_bottom, $margin_top_other = 0, $margin_bottom_other = 0)
{
    $spacing_values = get_theme_spacing_values();
    $styles = array();

    // Handle margin top
    if ($margin_top && $margin_top !== 'none') {
        if ($margin_top === 'other') {
            $styles[] = 'margin-top: ' . intval($margin_top_other) . 'px';
        } else {
            $styles[] = 'margin-top: ' . $spacing_values[$margin_top] . 'px';
        }
    }

    // Handle margin bottom
    if ($margin_bottom && $margin_bottom !== 'none') {
        if ($margin_bottom === 'other') {
            $styles[] = 'margin-bottom: ' . intval($margin_bottom_other) . 'px';
        } else {
            $styles[] = 'margin-bottom: ' . $spacing_values[$margin_bottom] . 'px';
        }
    }

    return implode('; ', $styles);
}

/**
 * Generate unique block ID
 * 
 * @param string $block_type The type of block (e.g., 'wysiwyg', 'image')
 * @return string Unique block ID
 */
function generate_unique_block_id($block_type = 'block')
{
    return $block_type . '-' . uniqid();
}

/**
 * Output responsive spacing CSS in a style tag with unique ID
 * 
 * @param string $margin_top The margin top value
 * @param string $margin_bottom The margin bottom value
 * @param int $margin_top_other Custom margin top value
 * @param int $margin_bottom_other Custom margin bottom value
 * @param string $unique_id The unique ID for the block instance
 */
function output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other = 0, $margin_bottom_other = 0, $unique_id = '')
{
    $css = generate_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $unique_id);

    if (!empty($css)) {
        echo '<style>' . "\n" . $css . '</style>' . "\n";
    }
}

/**
 * Get responsive breakpoint values
 * 
 * @return array Breakpoint values
 */
function get_theme_breakpoints()
{
    return array(
        'tablet' => '1199px',
        'mobile' => '767px'  // Updated from 991px
    );
}
