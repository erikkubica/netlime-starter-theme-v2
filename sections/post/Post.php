<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class Post extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/view.php";
    }
}