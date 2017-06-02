<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class SidebarRight extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/sidebar_right.php";
    }
}