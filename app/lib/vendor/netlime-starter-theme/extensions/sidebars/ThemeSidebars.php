<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeSidebars extends ThemeModuleBase
{
    public function init()
    {
        $this->registerSidebars();
    }

    /**
     * Register sidebars
     */
    protected function registerSidebars()
    {
        do_action("before_theme_register_sidebars");

        foreach ($this->getConfig("sidebars") as $id => $sidebar):
            add_action("widgets_init", function () use ($id, $sidebar) {
                register_sidebar(array(
                    'name' => __($sidebar["name"], 'sections'),
                    'id' => $id,
                    'description' => __($sidebar["description"], 'sections'),
                    'before_widget' => '<' . $sidebar["html_tag"] . ' class="' . $sidebar["html_class"] . '">',
                    'after_widget' => '</' . $sidebar["html_tag"] . '>',
                    'before_title' => '<' . $sidebar["heading_tag"] . ' class="' . $sidebar["heading_class"] . '">',
                    'after_title' => '</' . $sidebar["heading_tag"] . '>',
                ));
            });
        endforeach;

        do_action("after_theme_register_sidebars");
    }
}