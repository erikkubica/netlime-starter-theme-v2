<?php

### If you want to load modules manually set to false
define("THEME_AUTOLOAD_MODULES", false);

# Setup theme
require_once __DIR__ . "/app/lib/helper.php";

### Load modules
add_action("after_theme_autoload_modules", function () {
    theme()->registerModule("ThemeAssets", new \NetLimeTheme\Extensions\ThemeAssets());
    theme()->registerModule("ThemeCache", new \NetLimeTheme\Extensions\ThemeCache());
    theme()->registerModule("ThemeImage", new \NetLimeTheme\Extensions\ThemeImage());
    theme()->registerModule("ThemeMenu", new \NetLimeTheme\Extensions\ThemeMenu());
    theme()->registerModule("ThemeNavigation", new \NetLimeTheme\Extensions\ThemeNavigation());
    theme()->registerModule("ThemeSidebars", new \NetLimeTheme\Extensions\ThemeSidebars());
    theme()->registerModule("ThemeSupports", new \NetLimeTheme\Extensions\ThemeSupports());
    theme()->registerModule("ThemeTitle", new \NetLimeTheme\Extensions\ThemeTitle());
    theme()->registerModule("ThemePagination", new \NetLimeTheme\Extensions\ThemePagination());
});

### Do before render
add_action("before_theme_render", function () {
    # To not write loop on single or page
    if (is_single() || is_page()):
        the_post();
    endif;
});

### Remove emoji in this theme
add_action('init', function () {
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    });
});

### Init theme after theme hooks are defined
theme()->init(true);