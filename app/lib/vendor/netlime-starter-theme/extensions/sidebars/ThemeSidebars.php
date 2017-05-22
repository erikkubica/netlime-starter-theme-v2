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
                    'before_widget' => $sidebar["before_widget"],
                    'after_widget' => $sidebar["after_widget"],
                    'before_title' => $sidebar["before_title"],
                    'after_title' => $sidebar["after_title"]
                ));
            });
        endforeach;

        do_action("after_theme_register_sidebars");
    }
}