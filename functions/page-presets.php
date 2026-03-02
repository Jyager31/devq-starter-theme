<?php
/**
 * DevQ Page Presets
 *
 * Common page layouts as block arrays for use with devq_create_page().
 * Fields use empty strings as placeholders — populate with real content per client.
 */

/**
 * Get all available page presets.
 *
 * @return array Preset name => blocks array
 */
function devq_get_page_presets() {
    return array(
        'home' => devq_preset_home(),
        'about' => devq_preset_about(),
        'contact' => devq_preset_contact(),
        'services' => devq_preset_services(),
        'landing' => devq_preset_landing(),
    );
}

/**
 * Home page preset: Hero + Text Image + Cards + Stats + Testimonials + CTA
 */
function devq_preset_home() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'style' => 'image',
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'primary_button' => '',
                'secondary_button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
                'overlay_color' => '#000000',
            ),
        ),
        array(
            'name' => 'Text Image',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'image' => '',
                'button' => '',
                'image_position' => 'right',
            ),
        ),
        array(
            'name' => 'Cards',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'Stats',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'background' => 'dark',
                'stats' => array(),
            ),
        ),
        array(
            'name' => 'Testimonials',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'style' => 'carousel',
                'testimonials' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'button' => '',
                'background' => 'primary',
            ),
        ),
    );
}

/**
 * About page preset: Hero Split + About + Team + CTA
 */
function devq_preset_about() {
    return array(
        array(
            'name' => 'Hero Split',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'primary_button' => '',
                'secondary_button' => '',
                'image' => '',
                'image_position' => 'right',
            ),
        ),
        array(
            'name' => 'About',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'image' => '',
                'button' => '',
                'show_stats' => 1,
                'stats' => array(),
            ),
        ),
        array(
            'name' => 'Team',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'columns' => '4',
                'members' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'button' => '',
                'background' => 'primary',
            ),
        ),
    );
}

/**
 * Contact page preset: Hero + Contact Split
 */
function devq_preset_contact() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'style' => 'solid',
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'primary_button' => '',
                'background_color' => '',
            ),
        ),
        array(
            'name' => 'Contact Split',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'show_phone' => 1,
                'show_email' => 1,
                'show_address' => 1,
                'show_hours' => 1,
                'hours' => '',
                'show_map' => 0,
                'map_embed' => '',
                'form_shortcode' => '',
            ),
        ),
    );
}

/**
 * Services page preset: Hero + Features List + Cards + Process + FAQ + CTA
 */
function devq_preset_services() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'style' => 'image',
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'primary_button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Features List',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'columns' => '2',
                'features' => array(),
            ),
        ),
        array(
            'name' => 'Cards',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'Process',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'steps' => array(),
            ),
        ),
        array(
            'name' => 'FAQ',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'items' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'button' => '',
                'background' => 'primary',
            ),
        ),
    );
}

/**
 * Landing page preset: Hero + Text Image + Cards + Testimonials + Pricing + FAQ + CTA
 */
function devq_preset_landing() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'style' => 'image',
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'primary_button' => '',
                'secondary_button' => '',
                'background_image' => '',
                'overlay_opacity' => 60,
            ),
        ),
        array(
            'name' => 'Text Image',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'image' => '',
                'button' => '',
                'image_position' => 'right',
            ),
        ),
        array(
            'name' => 'Cards',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'Testimonials',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'style' => 'carousel',
                'testimonials' => array(),
            ),
        ),
        array(
            'name' => 'Pricing',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'plans' => array(),
            ),
        ),
        array(
            'name' => 'FAQ',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'subheading' => '',
                'items' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'eyebrow' => '',
                'heading' => '',
                'content' => '',
                'button' => '',
                'background' => 'primary',
            ),
        ),
    );
}
