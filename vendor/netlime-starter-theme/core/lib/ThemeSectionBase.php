<?php

namespace NetLimeTheme\Core\Lib;

class ThemeSectionBase implements ThemeSectionBaseInterface
{
    public $cache = false;
    public $template = false;
    public $data = [];

    function __construct($cache = false)
    {
        $this->cache = $cache;
    }

    /**
     * Initialise the section
     */
    function init()
    {
    }

    /**
     * Do something before rendering section
     */
    public function beforeRender()
    {
    }

    /**
     * Do something after rendering section
     */
    public function afterRender()
    {
    }

    /**
     * Render the section
     */
    public function render()
    {
        if (!file_exists($this->template)):
            throw new \Exception("Template of section is not defined.");
        endif;

        $func = $this->closedRender($this->template, $this->data);
        $func();
    }

    /**
     * This will close rending into sandbox disallowing to use $this
     * in the view layer
     *
     * @param $file
     * @param $data
     * @return mixed
     */
    public function closedRender($file, $data)
    {
        return static function () use ($file, $data) {
            extract($data);
            include $file;
        };
    }
}