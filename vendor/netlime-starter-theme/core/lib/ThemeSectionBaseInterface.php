<?php

namespace NetLimeTheme\Core\Lib;

interface ThemeSectionBaseInterface
{
    function __construct($cache = false);

    /**
     * Initialise the section
     */
    function init();

    /**
     * Do something before rendering section
     */
    public function beforeRender();

    /**
     * Do something after rendering section
     */
    public function afterRender();
    /**
     * Render the section
     */
    public function render();

    /**
     * This will close rending into sandbox disallowing to use $this
     * in the view layer
     *
     * @param $file
     * @param $data
     * @return mixed
     */
    public function closedRender($file, $data);
}