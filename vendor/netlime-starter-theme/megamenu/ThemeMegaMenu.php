<?php

namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeMegaMenu extends ThemeModuleBase
{
    protected $fields = array();

    public function init()
    {
        $this->fields = $this->getConfig("fields");

        add_action('wp_nav_menu_item_custom_fields', array($this, 'registerFields'), 10, 4);

        add_action('wp_update_nav_menu_item', array($this, 'saveFieldsData'), 10, 3);
        add_filter('manage_nav-menus_columns', array($this, 'mergeColumns'), 99);
        add_filter('wp_edit_nav_menu_walker', array($this, 'menuEditorWalker'), 99);
        add_filter('walker_nav_menu_start_el', array($this, "renderMegaMenuShortCode"), 10, 4);
    }

    public function renderMegaMenuShortCode($item_output, $item, $depth, $args)
    {
        $isMegaMenu = get_post_meta($item->ID, "menu-item-megamenu", true) == 1;

        if (!$isMegaMenu):
            return $item_output;
        endif;

        if ($shortCode = get_post_meta($item->ID, "menu-item-shortcode", true)) :
            $item_output .= do_shortcode($shortCode);
        endif;

        return $item_output;
    }

    /**
     * Register fields for menu item required for mega menu
     *
     * @param $id
     * @param $item
     * @param $depth
     * @param $args
     */
    public function registerFields($id, $item, $depth, $args)
    {
        foreach ($this->fields as $_key => $data) :
            $key = sprintf('menu-item-%s', $_key);
            $id = sprintf('edit-%s-%s', $key, $item->ID);
            $name = sprintf('%s[%s]', $key, $item->ID);
            $value = get_post_meta($item->ID, $key, true);
            $class = sprintf('field-%s', $_key);
            ?>
            <p class="description description-wide <?php echo esc_attr($class) ?>">
                <?php if ($data["type"] == "bool"): ?>
                    <label>
                        <?= esc_html($data["name"]) ?><br/>
                        <select id="<?= esc_attr($id) ?>" class="widefat <?= esc_attr($id) ?>" name="<?= esc_attr($name) ?>">
                            <option value="0" <?= $value !== 1 ? " selected" : "" ?>><?= __("No", "theme") ?></option>
                            <option value="1" <?= $value == 1 ? " selected" : "" ?>><?= __("Yes", "theme") ?></option>
                        </select>
                    </label>
                <?php else: ?>
                    <label>
                        <?= esc_html($data["name"]) ?><br/>
                        <input type="text" id="<?= esc_attr($id) ?>" class="widefat <?= esc_attr($id) ?>" name="<?= esc_attr($name) ?>" value="<?= esc_attr($value) ?>"/>
                    </label>
                <?php endif; ?>
            </p>
            <?php
        endforeach;
    }

    public function mergeColumns($columns)
    {
        $columns = array_merge($columns, $this->fields);

        return $columns;
    }

    public function saveFieldsData($menu_id, $menu_item_db_id, $menu_item_args)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) :
            return;
        endif;

        check_admin_referer('update-nav_menu', 'update-nav-menu-nonce');

        foreach ($this->fields as $_key => $label) :
            $key = sprintf('menu-item-%s', $_key);

            if (!empty($_POST[$key][$menu_item_db_id])) :
                $value = $_POST[$key][$menu_item_db_id];
            else:
                $value = null;
            endif;

            if (!is_null($value)):
                update_post_meta($menu_item_db_id, $key, $value);
                echo "key:$key<br />";
            else:
                delete_post_meta($menu_item_db_id, $key);
            endif;
        endforeach;
    }

    public function menuEditorWalker($orignal_walker)
    {
        $walker = 'Menu_Item_Megamenu_Fields_Walker';

        if (!class_exists($walker)) :
            require_once dirname(__FILE__) . '/' . $walker . '.php';
        endif;

        return $walker;
    }
}