<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class SidebarLeft extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/sidebar_left.php";
    }
}