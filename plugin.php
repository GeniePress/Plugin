<?php

/**
 * Plugin Name:       Genie Plugin Example
 * Plugin URI:        https://lnk7.com/plugins/genie/
 * Description:       An Example Plugin Using the GeniePress Framework
 * Version:           0.1.1
 * Requires at least: 5.5
 * Author:            Sunil Jaiswal
 * Author URI:        https://lnk7.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lnk7-genie-plugin
 * Domain Path:       /languages
 */

namespace Plugin;

use Plugin\PostTypes\Page;
use Plugin\PostTypes\Post;
use Plugin\PostTypes\Testimonial;
use Lnk7\GeniePress\Genie;

include_once('vendor/autoload.php');

Genie::createPlugin()
    ->withComponents([
        Plugin::class,
        Post::class,
        Page::class,
        Testimonial::class,
        Shortcodes::class,
    ])
    ->start();
