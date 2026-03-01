<?php
/**
 * DevQ Page Builder Utility
 *
 * Programmatic page creation with ACF blocks.
 */

/**
 * Get ACF field keys from a block's JSON definition.
 * Parses acfjson/group_{blockname}_block.json and returns field_name => field_key map.
 * For repeater fields, also includes sub_fields mapped as repeater_name_sub_field_name => field_key.
 *
 * @param string $block_name The filtered block name (e.g., 'hero', 'textimage')
 * @return array Associative array of field_name => field_key
 */
function devq_get_acf_field_keys($block_name) {
    $theme_dir = get_template_directory();
    $json_file = $theme_dir . '/acfjson/group_' . $block_name . '_block.json';

    if (!file_exists($json_file)) {
        return array();
    }

    $json = json_decode(file_get_contents($json_file), true);
    if (!$json || !isset($json['fields'])) {
        return array();
    }

    $keys = array();
    foreach ($json['fields'] as $field) {
        // Skip tab fields
        if ($field['type'] === 'tab') {
            continue;
        }

        if (!empty($field['name']) && !empty($field['key'])) {
            $keys[$field['name']] = $field['key'];

            // Handle repeater sub_fields
            if ($field['type'] === 'repeater' && isset($field['sub_fields'])) {
                foreach ($field['sub_fields'] as $sub_field) {
                    if (!empty($sub_field['name']) && !empty($sub_field['key'])) {
                        $keys[$field['name'] . '_' . $sub_field['name']] = $sub_field['key'];
                    }
                }
            }
        }
    }

    return $keys;
}

/**
 * Generate Gutenberg block comment markup for an ACF block.
 *
 * @param string $block_name The filtered block name (e.g., 'hero')
 * @param string $block_id Unique block ID
 * @param array $fields Optional field data to embed in the block comment
 * @param array $field_keys Optional field_name => field_key map
 * @return string The block comment markup
 */
function devq_generate_block_markup($block_name, $block_id, $fields = array(), $field_keys = array()) {
    $data = array();

    foreach ($fields as $name => $value) {
        $data[$name] = $value;
        if (isset($field_keys[$name])) {
            $data['_' . $name] = $field_keys[$name];
        }
    }

    $block_attrs = array(
        'id' => $block_id,
        'name' => 'acf/' . $block_name,
        'data' => $data,
        'mode' => 'edit',
    );

    return '<!-- wp:acf/' . $block_name . ' ' . wp_json_encode($block_attrs) . ' /-->';
}

/**
 * Save ACF block field values as postmeta.
 *
 * ACF stores block fields as:
 * - {block_id}_{field_name} = value
 * - _{block_id}_{field_name} = field_key
 *
 * For repeater fields, it also stores:
 * - {block_id}_{repeater_name} = count (number of rows)
 * - {block_id}_{repeater_name}_{index}_{sub_field_name} = value
 * - _{block_id}_{repeater_name}_{index}_{sub_field_name} = sub_field_key
 *
 * @param int $post_id The post ID
 * @param string $block_id The unique block ID
 * @param array $fields Associative array of field_name => value
 * @param string $block_name The filtered block name for key lookups
 */
function devq_save_block_meta($post_id, $block_id, $fields, $block_name) {
    $field_keys = devq_get_acf_field_keys($block_name);

    foreach ($fields as $name => $value) {
        if (is_array($value) && isset($field_keys[$name])) {
            // Check if this is a repeater field by looking at the JSON
            $theme_dir = get_template_directory();
            $json_file = $theme_dir . '/acfjson/group_' . $block_name . '_block.json';
            $json = json_decode(file_get_contents($json_file), true);
            $is_repeater = false;

            if ($json && isset($json['fields'])) {
                foreach ($json['fields'] as $field) {
                    if ($field['name'] === $name && $field['type'] === 'repeater') {
                        $is_repeater = true;
                        break;
                    }
                }
            }

            if ($is_repeater) {
                // Save repeater count
                update_post_meta($post_id, $block_id . '_' . $name, count($value));
                update_post_meta($post_id, '_' . $block_id . '_' . $name, $field_keys[$name]);

                // Save each row
                foreach ($value as $index => $row) {
                    foreach ($row as $sub_name => $sub_value) {
                        $meta_key = $block_id . '_' . $name . '_' . $index . '_' . $sub_name;
                        update_post_meta($post_id, $meta_key, $sub_value);

                        $sub_field_key_name = $name . '_' . $sub_name;
                        if (isset($field_keys[$sub_field_key_name])) {
                            update_post_meta($post_id, '_' . $meta_key, $field_keys[$sub_field_key_name]);
                        }
                    }
                }
                continue;
            }
        }

        // Regular field
        $meta_key = $block_id . '_' . $name;
        update_post_meta($post_id, $meta_key, $value);

        if (isset($field_keys[$name])) {
            update_post_meta($post_id, '_' . $meta_key, $field_keys[$name]);
        }
    }
}

/**
 * Build block content from an array of block definitions.
 *
 * Each block definition should have:
 * - 'name' => block name (human readable like "Hero" or filtered like "hero")
 * - 'fields' => associative array of field_name => value
 *
 * @param array $blocks Array of block definitions
 * @return array ['post_content' => string, 'blocks_meta' => array of [block_id, fields, block_name]]
 */
function devq_build_block_content($blocks) {
    $content_parts = array();
    $blocks_meta = array();

    foreach ($blocks as $block) {
        $name = isset($block['name']) ? $block['name'] : '';
        $fields = isset($block['fields']) ? $block['fields'] : array();

        // Filter the name the same way the theme does
        $filtered_name = strtolower(str_replace(array(' ', '-'), '', $name));

        $block_id = 'block_' . uniqid();
        $field_keys = devq_get_acf_field_keys($filtered_name);

        $content_parts[] = devq_generate_block_markup($filtered_name, $block_id, $fields, $field_keys);

        $blocks_meta[] = array(
            'block_id' => $block_id,
            'fields' => $fields,
            'block_name' => $filtered_name,
        );
    }

    return array(
        'post_content' => implode("\n\n", $content_parts),
        'blocks_meta' => $blocks_meta,
    );
}

/**
 * Create a WordPress page with ACF blocks.
 *
 * @param array $args {
 *     @type string $title    Page title (required)
 *     @type string $slug     Page slug (optional, auto-generated from title)
 *     @type string $status   Post status: 'draft' or 'publish' (default: 'draft')
 *     @type int    $parent   Parent page ID (default: 0)
 *     @type string $template Page template file (default: '')
 *     @type array  $blocks   Array of block definitions, each with 'name' and 'fields'
 * }
 * @return int|WP_Error Post ID on success, WP_Error on failure
 */
function devq_create_page($args) {
    $defaults = array(
        'title' => '',
        'slug' => '',
        'status' => 'draft',
        'parent' => 0,
        'template' => '',
        'blocks' => array(),
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['title'])) {
        return new WP_Error('missing_title', 'Page title is required.');
    }

    // Build block content
    $block_data = devq_build_block_content($args['blocks']);

    // Create the page
    $post_data = array(
        'post_title' => sanitize_text_field($args['title']),
        'post_name' => $args['slug'] ? sanitize_title($args['slug']) : sanitize_title($args['title']),
        'post_content' => $block_data['post_content'],
        'post_status' => in_array($args['status'], array('draft', 'publish', 'private'), true) ? $args['status'] : 'draft',
        'post_type' => 'page',
        'post_parent' => absint($args['parent']),
    );

    $post_id = wp_insert_post($post_data, true);

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    // Set page template if provided
    if (!empty($args['template'])) {
        update_post_meta($post_id, '_wp_page_template', $args['template']);
    }

    // Save block meta
    foreach ($block_data['blocks_meta'] as $block_meta) {
        devq_save_block_meta($post_id, $block_meta['block_id'], $block_meta['fields'], $block_meta['block_name']);
    }

    return $post_id;
}

/**
 * REST API endpoint for creating pages (fallback when WP-CLI isn't available).
 */
function devq_register_rest_routes() {
    register_rest_route('devq/v1', '/create-page', array(
        'methods' => 'POST',
        'callback' => 'devq_rest_create_page',
        'permission_callback' => function () {
            return current_user_can('edit_pages');
        },
    ));
}
add_action('rest_api_init', 'devq_register_rest_routes');

/**
 * REST API callback for page creation.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function devq_rest_create_page($request) {
    $params = $request->get_json_params();

    if (empty($params)) {
        return new WP_REST_Response(array('error' => 'Invalid JSON body'), 400);
    }

    // Support preset-based creation
    if (!empty($params['preset'])) {
        $presets = devq_get_page_presets();
        if (!isset($presets[$params['preset']])) {
            return new WP_REST_Response(array('error' => 'Unknown preset: ' . $params['preset']), 400);
        }
        if (empty($params['blocks'])) {
            $params['blocks'] = $presets[$params['preset']];
        }
    }

    $result = devq_create_page($params);

    if (is_wp_error($result)) {
        return new WP_REST_Response(array('error' => $result->get_error_message()), 400);
    }

    return new WP_REST_Response(array(
        'post_id' => $result,
        'edit_url' => get_edit_post_link($result, 'raw'),
        'view_url' => get_permalink($result),
    ), 201);
}
