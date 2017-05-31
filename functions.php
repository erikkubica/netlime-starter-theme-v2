<?php

### If you want to load modules manually set to false
### Sometimes it´s recommended to have custom order
define("THEME_AUTOLOAD_MODULES", false);

### Setup theme
require_once __DIR__ . "/app/lib/helper.php";

### Load modules
add_action("after_theme_autoload_modules", function () {

    if (isset($_GET["debug"])):
        theme()->registerModule("ThemeDebug", new \NetLimeTheme\Extensions\ThemeDebug());
    endif;

    theme()->registerModule("ThemeDisableEmoji", new \NetLimeTheme\Extensions\ThemeDisableEmoji());
    theme()->registerModule("ThemeAssets", new \NetLimeTheme\Extensions\ThemeAssets());
    theme()->registerModule("ThemeCache", new \NetLimeTheme\Extensions\ThemeCache());
    theme()->registerModule("ThemeImage", new \NetLimeTheme\Extensions\ThemeImage());
    theme()->registerModule("ThemeMenu", new \NetLimeTheme\Extensions\ThemeMenu());
    theme()->registerModule("ThemeNavigation", new \NetLimeTheme\Extensions\ThemeNavigation());
    theme()->registerModule("ThemeSidebars", new \NetLimeTheme\Extensions\ThemeSidebars());
    theme()->registerModule("ThemeSupports", new \NetLimeTheme\Extensions\ThemeSupports());
    theme()->registerModule("ThemeTitle", new \NetLimeTheme\Extensions\ThemeTitle());
    theme()->registerModule("ThemePagination", new \NetLimeTheme\Extensions\ThemePagination());
    theme()->registerModule("ThemeMegaMenu", new \NetLimeTheme\Extensions\ThemeMegaMenu());
});

### Register wrappers
add_action("on_theme_register_wrappers", function () {
    theme()->registerWrapper("2column-right", "wrappers/2column-right.php");
    theme()->registerWrapper("2column-left", "wrappers/2column-left.php");
    theme()->registerWrapper("1column", "wrappers/1column.php");
});

### Register sections
add_action("on_theme_register_sections", function () {
    theme()->registerSection("header", "templates/general/header.php", true);
    theme()->registerSection("footer", "templates/general/footer.php", true);
    theme()->registerSection("sidebar_right", "templates/general/sidebar_right.php", true);
    theme()->registerSection("sidebar_left", "templates/general/sidebar_left.php", true);
    theme()->registerSection("comments", "templates/general/comments.php", true);
    theme()->registerSection("search_header", "templates/general/search_header.php", true);
    theme()->registerSection("pagination", "templates/general/pagination.php", true);
    theme()->registerSection("post_list", "templates/post/list.php", true);
    theme()->registerSection("post_content", "templates/post/content.php", true);
    theme()->registerSection("page_content", "templates/page/content.php", true);
    theme()->registerSection("404_content", "templates/404/content.php", true);
});

### Do before render
add_action("before_theme_render", function () {
    # To avoid creating the_loop on single*.php or page*.php
    # If you are not lazy to write while(...) the_post();...
    # then remove this hook
    if (is_single() || is_page()):
        the_post();
    endif;
});

### Add MegaMenu ShortCode
add_shortcode('megamenu', function ($atts) {
    $atts = shortcode_atts(array(
        'posts' => ""
    ), $atts, 'megamenu');

    $html = "";
    $ids = explode(",", $atts["posts"]);

    if (!is_array($ids)) {
        return "";
    }

    $posts = get_posts(array("post__in" => $ids));

    if (!is_array($posts)) {
        return "";
    }

    $html .= "<div style='border:1px solid black;padding: 1rem;'>";
    $html .= "<strong>TODO: Style this megamenu to show on hover</strong><br/><br/>";
    foreach ($posts as $post) {
        $html .= "<p>" . $post->post_title . "</p>";
    }
    $html .= "</div>";

    return $html;

});

### Init theme after theme hooks are defined
theme()->init(!isset($_GET["devmode"]));