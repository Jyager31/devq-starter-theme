<?php
/**
 * DevQ Theme Disconnect
 *
 * One-click flatten: merges child theme into parent, disables GitHub
 * auto-updates, renames the theme, and removes all DevQ framework ties.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Disconnect page under Tools.
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'Disconnect Theme',
        'Disconnect Theme',
        'manage_options',
        'devq-disconnect',
        'devq_disconnect_page'
    );
});

/**
 * Show success notice after disconnect redirect.
 */
add_action('admin_notices', function () {
    if (!empty($_GET['devq-disconnected'])) {
        $name = sanitize_text_field(wp_unslash($_GET['devq-disconnected']));
        echo '<div class="notice notice-success is-dismissible"><p>';
        echo '<strong>Theme disconnected.</strong> This site now runs the standalone &ldquo;' . esc_html($name) . '&rdquo; theme.';
        echo '</p></div>';
    }
});

/**
 * Render the admin page and handle the POST action.
 */
function devq_disconnect_page()
{
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized.');
    }

    // ── Handle POST ─────────────────────────────────────────────────────
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devq_disconnect_nonce'])) {
        if (!wp_verify_nonce($_POST['devq_disconnect_nonce'], 'devq_disconnect_action')) {
            wp_die('Invalid nonce.');
        }

        $client_name = sanitize_text_field(wp_unslash($_POST['client_name'] ?? ''));
        if (empty($client_name)) {
            wp_die('Client name is required.');
        }

        devq_execute_disconnect($client_name);
        // devq_execute_disconnect redirects on success — execution won't reach here.
        return;
    }

    // ── Status detection ────────────────────────────────────────────────
    $parent_dir     = get_template_directory();
    $child_dir      = get_stylesheet_directory();
    $has_child       = ($child_dir !== $parent_dir);
    $updater_exists  = file_exists($parent_dir . '/functions/theme-updater.php');
    $current_theme   = wp_get_theme();
    $child_theme     = $has_child ? wp_get_theme(basename($child_dir)) : null;
    $prefill_name    = '';

    if ($child_theme && $child_theme->exists()) {
        $prefill_name = $child_theme->get('Name');
        if ($prefill_name === 'DevQ Starter' || $prefill_name === 'Client Name') {
            $prefill_name = '';
        }
    }

    ?>
    <div class="wrap">
        <h1>Disconnect Theme</h1>
        <p>Sever this site's connection to the DevQ framework. This merges the child theme into the parent, disables auto-updates, and renames the theme — leaving a standalone theme with zero DevQ ties.</p>

        <h2>Current Status</h2>
        <table class="widefat striped" style="max-width:500px;">
            <tr>
                <td><strong>Active Theme</strong></td>
                <td><?php echo esc_html($current_theme->get('Name')); ?></td>
            </tr>
            <tr>
                <td><strong>Child Theme</strong></td>
                <td>
                    <?php if ($has_child) : ?>
                        <span style="color:#d63638;">Active</span> — <?php echo esc_html(basename($child_dir)); ?>
                    <?php else : ?>
                        <span style="color:#00a32a;">Not active</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Auto-Updater</strong></td>
                <td>
                    <?php if ($updater_exists) : ?>
                        <span style="color:#d63638;">Enabled</span>
                    <?php else : ?>
                        <span style="color:#00a32a;">Disabled</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php if (!$has_child && !$updater_exists) : ?>
            <div class="notice notice-success inline" style="margin-top:20px;">
                <p>This theme is already disconnected. Nothing to do.</p>
            </div>
        <?php else : ?>
            <form method="post" style="margin-top:20px; max-width:500px;">
                <?php wp_nonce_field('devq_disconnect_action', 'devq_disconnect_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="client_name">Client / Theme Name</label></th>
                        <td>
                            <input type="text" id="client_name" name="client_name"
                                   value="<?php echo esc_attr($prefill_name); ?>"
                                   class="regular-text" required
                                   placeholder="e.g. Acme Corp" />
                            <p class="description">The theme will be renamed to this value.</p>
                        </td>
                    </tr>
                </table>
                <p>
                    <button type="submit" class="button" id="devq-disconnect-btn"
                            style="background:#d63638; border-color:#d63638; color:#fff; padding:6px 20px; font-size:14px;">
                        Disconnect Theme
                    </button>
                </p>
            </form>
            <script>
            document.getElementById('devq-disconnect-btn').addEventListener('click', function(e) {
                var name = document.getElementById('client_name').value.trim();
                if (!name) { return; }
                if (!confirm(
                    'WARNING: This will permanently:\n\n' +
                    '• Merge the child theme into the parent\n' +
                    '• Disable GitHub auto-updates\n' +
                    '• Rename the theme to "' + name + '"\n' +
                    '• Delete the child theme directory\n\n' +
                    'This cannot be undone. Continue?'
                )) {
                    e.preventDefault();
                }
            });
            </script>
        <?php endif; ?>
    </div>
    <?php
}


/**
 * Execute the full disconnect sequence.
 */
function devq_execute_disconnect(string $client_name)
{
    $parent_dir = get_template_directory();
    $child_dir  = get_stylesheet_directory();
    $has_child  = ($child_dir !== $parent_dir);

    // ── 1. Copy child theme assets into parent ──────────────────────────
    if ($has_child) {
        $dirs_to_copy = array('blocks', 'acfjson');
        foreach ($dirs_to_copy as $dir) {
            $src = $child_dir . '/' . $dir;
            if (is_dir($src)) {
                devq_recursive_copy($src, $parent_dir . '/' . $dir);
            }
        }
    }

    // ── 2. Merge child theme PHP ────────────────────────────────────────
    if ($has_child && file_exists($child_dir . '/functions.php')) {
        $child_php = file_get_contents($child_dir . '/functions.php');
        $custom_code = devq_extract_child_customizations($child_php);

        if (!empty(trim($custom_code))) {
            $custom_file = $parent_dir . '/functions/client-customizations.php';
            file_put_contents($custom_file, "<?php\n/**\n * Client customizations (migrated from child theme).\n */\n\n" . $custom_code . "\n");

            // Add require to parent functions.php
            $parent_functions = $parent_dir . '/functions.php';
            $parent_php = file_get_contents($parent_functions);
            $require_line = "require get_template_directory() . '/functions/client-customizations.php';";

            if (strpos($parent_php, 'client-customizations.php') === false) {
                // Insert before the theme-updater require (or theme-disconnect require)
                $anchor = "require get_template_directory() . '/functions/theme-disconnect.php';";
                if (strpos($parent_php, $anchor) !== false) {
                    $parent_php = str_replace($anchor, $require_line . "\n" . $anchor, $parent_php);
                } else {
                    $anchor = "require get_template_directory() . '/functions/theme-updater.php';";
                    $parent_php = str_replace($anchor, $require_line . "\n" . $anchor, $parent_php);
                }
                file_put_contents($parent_functions, $parent_php);
            }
        }
    }

    // ── 3. Add child blocks to parent's block list ──────────────────────
    if ($has_child) {
        $child_blocks = devq_parse_child_block_names($child_dir);
        if (!empty($child_blocks)) {
            devq_add_blocks_to_parent($parent_dir, $child_blocks);
        }
    }

    // ── 4. Rename the theme ─────────────────────────────────────────────
    $style_path = $parent_dir . '/style.css';
    $style_css = file_get_contents($style_path);
    $style_css = preg_replace('/^Theme Name:\s*.+$/m', 'Theme Name: ' . $client_name, $style_css);
    file_put_contents($style_path, $style_css);

    // ── 5. Disable the updater ──────────────────────────────────────────
    $updater_file = $parent_dir . '/functions/theme-updater.php';
    if (file_exists($updater_file)) {
        @unlink($updater_file);
    }
    $puc_dir = $parent_dir . '/plugin-update-checker';
    if (is_dir($puc_dir)) {
        devq_recursive_delete($puc_dir);
    }

    // Remove updater require from functions.php
    $parent_functions = $parent_dir . '/functions.php';
    $parent_php = file_get_contents($parent_functions);
    $parent_php = devq_remove_require_line($parent_php, 'theme-updater.php');
    file_put_contents($parent_functions, $parent_php);

    // ── 6. Switch active theme ──────────────────────────────────────────
    if ($has_child) {
        switch_theme('devq-starter');
    }

    // ── 7. Delete child theme ───────────────────────────────────────────
    if ($has_child && is_dir($child_dir)) {
        devq_recursive_delete($child_dir);
    }

    // ── 8. Self-cleanup ─────────────────────────────────────────────────
    // Remove our require line from functions.php first (re-read in case step 2/5 modified it)
    $parent_php = file_get_contents($parent_functions);
    $parent_php = devq_remove_require_line($parent_php, 'theme-disconnect.php');
    file_put_contents($parent_functions, $parent_php);

    // Delete this file (schedule for after redirect since we're executing from it)
    $self_file = $parent_dir . '/functions/theme-disconnect.php';
    register_shutdown_function(function () use ($self_file) {
        if (file_exists($self_file)) {
            @unlink($self_file);
        }
    });

    // ── 9. Set flag ─────────────────────────────────────────────────────
    update_option('devq_theme_disconnected', true);

    // Redirect with success notice
    wp_safe_redirect(admin_url('themes.php?devq-disconnected=' . urlencode($client_name)));
    exit;
}


// ─── Helper Functions ───────────────────────────────────────────────────────

/**
 * Recursively copy a directory. Skip files that already exist in the destination.
 */
function devq_recursive_copy(string $src, string $dst)
{
    if (!is_dir($dst)) {
        wp_mkdir_p($dst);
    }
    $items = new DirectoryIterator($src);
    foreach ($items as $item) {
        if ($item->isDot()) {
            continue;
        }
        $src_path = $item->getPathname();
        $dst_path = $dst . '/' . $item->getFilename();
        if ($item->isDir()) {
            devq_recursive_copy($src_path, $dst_path);
        } elseif (!file_exists($dst_path)) {
            copy($src_path, $dst_path);
        }
    }
}

/**
 * Recursively delete a directory and its contents.
 */
function devq_recursive_delete(string $dir)
{
    if (!is_dir($dir)) {
        return;
    }
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($items as $item) {
        if ($item->isDir()) {
            @rmdir($item->getPathname());
        } else {
            @unlink($item->getPathname());
        }
    }
    @rmdir($dir);
}

/**
 * Extract custom code from a child theme's functions.php.
 *
 * Strips the opening <?php tag, the style-enqueue function + its
 * add_action, and the boilerplate doc comment block about overrides.
 * Returns the remaining code (CPTs, taxonomies, block filters, etc.).
 */
function devq_extract_child_customizations(string $php_code): string
{
    // Remove opening PHP tag
    $code = preg_replace('/^<\?php\s*/', '', $php_code);

    // Remove the style enqueue function and its add_action
    $code = preg_replace(
        '/function\s+devq_child_enqueue_styles\s*\(\)\s*\{[^}]*\}\s*add_action\s*\(\s*[\'"]wp_enqueue_scripts[\'"]\s*,\s*[\'"]devq_child_enqueue_styles[\'"]\s*,\s*\d+\s*\)\s*;\s*/s',
        '',
        $code
    );

    // Remove the boilerplate doc comment block about child theme block overrides
    $code = preg_replace(
        '/\/\*\*\s*\n\s*\*\s*─+\s*\n\s*\*\s*CHILD THEME BLOCK OVERRIDES\s*\n.*?\*\/\s*/s',
        '',
        $code
    );

    return $code;
}

/**
 * Parse block names added via the devq_blocks filter in the child theme.
 */
function devq_parse_child_block_names(string $child_dir): array
{
    $blocks = array();
    $functions_file = $child_dir . '/functions.php';

    if (!file_exists($functions_file)) {
        return $blocks;
    }

    $code = file_get_contents($functions_file);

    // Match $blocks[] = 'Block Name'; patterns
    if (preg_match_all('/\$blocks\[\]\s*=\s*[\'"]([^\'"]+)[\'"]\s*;/', $code, $matches)) {
        $blocks = $matches[1];
    }

    return $blocks;
}

/**
 * Add block names directly to the $blocks array in functions/blocks.php.
 */
function devq_add_blocks_to_parent(string $parent_dir, array $new_blocks)
{
    $blocks_file = $parent_dir . '/functions/blocks.php';
    if (!file_exists($blocks_file)) {
        return;
    }

    $code = file_get_contents($blocks_file);

    // Find the closing of the $blocks array — the ");" after the last entry
    // We insert new entries just before the closing ");".
    $pattern = '/([ \t]*"Before After",?\s*)\n(\s*\);)/';
    if (preg_match($pattern, $code)) {
        $additions = '';
        foreach ($new_blocks as $name) {
            $additions .= '        "' . $name . '",' . "\n";
        }
        $code = preg_replace(
            $pattern,
            '$1' . "\n" . $additions . '$2',
            $code
        );
    }

    file_put_contents($blocks_file, $code);
}

/**
 * Remove a require line referencing the given filename from a PHP string.
 */
function devq_remove_require_line(string $code, string $filename): string
{
    // Remove the entire require line (with optional surrounding blank lines)
    $escaped = preg_quote($filename, '/');
    $code = preg_replace(
        '/\n?require\s+get_template_directory\(\)\s*\.\s*[\'"]\/functions\/' . $escaped . '[\'"]\s*;\s*\n?/',
        "\n",
        $code
    );
    // Clean up any resulting double blank lines
    $code = preg_replace('/\n{3,}/', "\n\n", $code);
    return $code;
}
