<?php

/**
 * Plugin Name:       Genie Plugin Example
 * Plugin URI:        https://geniepress.org
 * Description:       An Example Plugin Using the GeniePress Framework
 * Version:           1.0.1
 * Requires at least: 5.5
 * Author:            Sunil Jaiswal
 * Author URI:        https://geniepress.org
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lnk7-genie-plugin
 * Domain Path:       /languages
 */

namespace Plugin;

use GeniePress\Genie;
use Plugin\PostTypes\Page;
use Plugin\PostTypes\Post;
use Plugin\PostTypes\Sample;
use Plugin\PostTypes\Testimonial;

include_once('vendor/autoload.php');

Genie::createPlugin()
    ->enableAjaxHandler()
    ->enableApiHandler()
    ->enableBackgroundJobs()
    ->enableCacheBuster()
    ->enableDeploymentHandler()
    ->withComponents([

        // Our main Plugin
        Plugin::class,

        // Our Post Types
        Post::class,
        Page::class,
        Testimonial::class,
        Sample::class,

        // utilities
        Shortcodes::class,
    ])
    ->start();
