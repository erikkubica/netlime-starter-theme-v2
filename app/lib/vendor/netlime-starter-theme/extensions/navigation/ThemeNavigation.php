<?php

namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeNavigation extends ThemeModuleBase
{
    protected $fields = array();

    public function init()
    {
        $this->registerNavigation();
    }

    /**
     * Register navigation menus
     */
    protected function registerNavigation()
    {
        do_action("before_theme_register_navigation");

        foreach ($this->getConfig("navigation") as $name => $description):
            register_nav_menu($name, $description);
        endforeach;

        do_action("after_theme_register_navigation");
    }
}

?>