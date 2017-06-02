<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class PostList extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/list.php";
    }
}