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
 * Home page preset: Hero + Text Image + Cards + CTA
 */
function devq_preset_home() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Text Image',
            'fields' => array(
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
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'heading' => '',
                'content' => '',
                'button' => '',
                'background_color' => '',
            ),
        ),
    );
}

/**
 * About page preset: Hero + WYSIWYG + Text Image + CTA
 */
function devq_preset_about() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Wysiwyg',
            'fields' => array(
                'wysiwyg' => '',
            ),
        ),
        array(
            'name' => 'Text Image',
            'fields' => array(
                'heading' => '',
                'content' => '',
                'image' => '',
                'button' => '',
                'image_position' => 'left',
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'heading' => '',
                'content' => '',
                'button' => '',
                'background_color' => '',
            ),
        ),
    );
}

/**
 * Contact page preset: Hero + WYSIWYG
 */
function devq_preset_contact() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Wysiwyg',
            'fields' => array(
                'wysiwyg' => '',
            ),
        ),
    );
}

/**
 * Services page preset: Hero + WYSIWYG + Cards + FAQ + CTA
 */
function devq_preset_services() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Wysiwyg',
            'fields' => array(
                'wysiwyg' => '',
            ),
        ),
        array(
            'name' => 'Cards',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'FAQ',
            'fields' => array(
                'heading' => '',
                'items' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'heading' => '',
                'content' => '',
                'button' => '',
                'background_color' => '',
            ),
        ),
    );
}

/**
 * Landing page preset: Hero + Text Image + Cards + FAQ + CTA
 */
function devq_preset_landing() {
    return array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => '',
                'subheading' => '',
                'button' => '',
                'background_image' => '',
                'overlay_opacity' => 50,
            ),
        ),
        array(
            'name' => 'Text Image',
            'fields' => array(
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
                'heading' => '',
                'subheading' => '',
                'columns' => '3',
                'cards' => array(),
            ),
        ),
        array(
            'name' => 'FAQ',
            'fields' => array(
                'heading' => '',
                'items' => array(),
            ),
        ),
        array(
            'name' => 'CTA',
            'fields' => array(
                'heading' => '',
                'content' => '',
                'button' => '',
                'background_color' => '',
            ),
        ),
    );
}
