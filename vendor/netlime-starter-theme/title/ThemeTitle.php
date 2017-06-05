<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeTitle extends ThemeModuleBase
{
    public function init()
    {
        $this->registerTitle();
    }

    /**
     * Add wp_title() to wp_head()
     */
    protected function registerTitle()
    {
        add_action("wp_head", function () {
            echo '<title>';
            wp_title();
            echo '</title>';
        });
    }
}