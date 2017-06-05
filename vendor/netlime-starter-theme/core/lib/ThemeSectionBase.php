<?php

namespace NetLimeTheme\Core\Lib;

class ThemeSectionBase
{
    public $cache = false;
    public $template = false;
    public $data = [];

    function __construct($cache = false)
    {
        $this->cache = $cache;
    }

    function init(){

    }

    public function render()
    {
        if (!file_exists($this->template)):
            throw new \Exception("Template of section is not defined.");
        endif;
        
        $func = $this->closedRender($this->template, $this->data);
        $func();
    }

    protected function closedRender($file, $data)
    {
        return static function () use ($file, $data) {
            extract($data);
            require $file;
        };
    }


}