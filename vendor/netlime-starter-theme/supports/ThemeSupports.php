<?php

namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeSupports extends ThemeModuleBase
{

    public function init()
    {
        $this->registerSupports();
    }

    /**
     * Add theme features
     */
    protected function registerSupports()
    {
        do_action("before_theme_add_supports");

        foreach ($this->getConfig("supports") as $feature => $enabled):
            if (!$enabled):
                continue;
            endif;
            add_theme_support($feature);
        endforeach;

        do_action("after_theme_add_supports");
    }
}