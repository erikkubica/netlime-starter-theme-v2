<?php

### If you want to load modules manually set to false
### Sometimes it´s recommended to have custom order
define("THEME_AUTOLOAD_MODULES", false);

### Setup theme
require_once __DIR__ . "/init.php";

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
    theme()->registerWrapper("2column-right", "view/wrappers/2column-right.php");
    theme()->registerWrapper("2column-left", "view/wrappers/2column-left.php");
    theme()->registerWrapper("1column", "view/wrappers/1column.php");
});

### Register sections
add_action("on_theme_register_sections", function () {
    /*
    theme()->registerSection("search_header", "templates/general/search_header.php", true);
    */

    theme()->registerSection("Comments", new \NetLimeTheme\Sections\Comments(true));
    theme()->registerSection("Pagination", new \NetLimeTheme\Sections\Pagination(true));
    theme()->registerSection("Footer",  new \NetLimeTheme\Sections\Footer(true));
    theme()->registerSection("Header",  new \NetLimeTheme\Sections\Header(true));
    theme()->registerSection("SidebarRight", new \NetLimeTheme\Sections\SidebarRight(true));
    theme()->registerSection("SidebarLeft", new \NetLimeTheme\Sections\SidebarLeft(true));
    theme()->registerSection("Search", new \NetLimeTheme\Sections\Search(true));
    theme()->registerSection("Post", new \NetLimeTheme\Sections\Post(true));
    theme()->registerSection("PostList", new \NetLimeTheme\Sections\PostList(true));
    theme()->registerSection("NotFound", new \NetLimeTheme\Sections\NotFound(true));
    theme()->registerSection("Page", new \NetLimeTheme\Sections\Page(true));
    theme()->registerSection("Test", new \NetLimeTheme\Sections\Test(true));
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