<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class Page extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/view.php";
    }
}