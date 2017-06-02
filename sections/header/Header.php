<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class Header extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/view.php";
    }
}