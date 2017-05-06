<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeMenu extends ThemeModuleBase
{

    public static function init()
    {
        self::fixActive();
    }

    /**
     * Makes archive menu link active when viewing CPT single
     */
    protected static function fixActive()
    {
        add_action('nav_menu_css_class', function ($classes, $item) {
            global $post;

            if (!$post) {
                return $classes;
            }

            $current_post_type = get_post_type_object(get_post_type($post->ID));
            $current_post_type_slug = $current_post_type->rewrite["slug"];
            $menu_slug = strtolower(trim($item->url));
            $is_current_based_on_url = strpos($menu_slug, $current_post_type_slug) !== false;
            $active = false;
            $is_post_page = in_array($post->post_type, ["page", "post"]);

            if ($is_current_based_on_url) {
                $active = true;
            } elseif (in_array("current-menu-item", $classes) && !$is_post_page) {
                $active = true;
            } elseif (in_array("current_page_parent", $classes) && $is_post_page) {
                $active = true;
            } elseif (in_array("current-menu-item", $classes) && $is_post_page) {
                $active = true;
            }

            if ($active) {
                $classes[] = 'current-menu-item active';
            }

            return $classes;
        }, 10, 2);
    }
}