<?php

namespace NetLimeTheme\Sections;

use NetLimeTheme\Core\Lib\ThemeSectionBase;

class Test extends ThemeSectionBase
{
    function init()
    {
        $this->template = dirname(__FILE__) . "/view/view.php";

        $this->data["posts"] = get_posts();
    }
}