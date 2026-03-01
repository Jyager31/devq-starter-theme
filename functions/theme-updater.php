<?php
/**
 * DevQ Starter Theme - Auto Update via GitHub Releases
 *
 * Checks the public GitHub repo for new tagged releases.
 * No configuration needed — works automatically on any site.
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$puc_autoloader = get_template_directory() . '/plugin-update-checker/plugin-update-checker.php';

if (file_exists($puc_autoloader)) {
    require $puc_autoloader;

    $devq_update_checker = PucFactory::buildUpdateChecker(
        'https://github.com/Jyager31/devq-starter-theme/',
        get_template_directory() . '/functions.php',
        'devq-starter'  // must match directory name
    );

    $devq_update_checker->getVcsApi()->enableReleaseAssets();
}
