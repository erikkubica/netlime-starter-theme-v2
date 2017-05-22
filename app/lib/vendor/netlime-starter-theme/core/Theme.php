<?php
namespace NetLimeTheme\Core;

use NetLimeTheme\Core\Lib\ThemeModuleBase;
use Symfony\Component\Yaml\Yaml;

class Theme extends ThemeModuleBase
{
    protected $modules = [];
    private $configs = ["wrappers", "sections"];
    private $production = false;
    private $sections = [];
    private $wrapper = false;
    public $is_ajax = false;
    public $is_post_req = false;
    public $theme_dir;

    /**
     * Init theme
     *
     * @param bool $production True false to enable caching if cache module is enabled
     */
    public function init($production = false)
    {
        setTheme($this);

        do_action("before_theme_setup");

        # Set mode
        $this->production = $production;

        # Set some other params
        $this->is_ajax = defined('DOING_AJAX') && DOING_AJAX;
        $this->is_post_req = $_SERVER['REQUEST_METHOD'] == 'POST';
        $this->theme_dir = get_template_directory();

        # Load extensions
        do_action("before_theme_autoload_modules");
        if (THEME_AUTOLOAD_MODULES):
            $this->autoLoadModules();
        endif;
        do_action("after_theme_autoload_modules");

        # Core setup
        $this->initConfig();

        do_action("after_theme_setup");
    }

    /**
     * Auto load extensions
     */
    protected function autoLoadModules()
    {
        $extDirectory = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "extensions" . DIRECTORY_SEPARATOR;
        $extDirectories = glob($extDirectory . "*", GLOB_ONLYDIR);

        foreach ($extDirectories as $directory):
            # Get className and classPath
            $className = substr(basename(glob($directory . "*/Theme*.php")[0]), 0, -4);
            $classPath = '\\NetLimeTheme\\Extensions\\' . $className;
            $this->registerModule($className, new $classPath());
        endforeach;
    }

    /**
     * Register theme module
     *
     * @param $key string Register module under this key
     * @param $instance
     */
    public function registerModule($key, $instance)
    {
        do_action("before_theme_module_register", $key, $instance);
        $this->modules[$key] = $instance;

        do_action("before_theme_module_init", $key, $instance);

        $this->module($key)->init();

        do_action("after_theme_module_init", $key, $instance);

        do_action("after_theme_module_register", $key, $instance);
    }

    /**
     * Get theme module using it´s key
     *
     * @param $key
     * @return mixed
     */
    public function module($key)
    {
        do_action("before_theme_get_module", $key);

        return $this->modules[$key];
    }

    /**
     * Initializes theme configuration
     */
    protected function initConfig()
    {
        do_action("before_theme_init_config");

        foreach ($this->configs as $c):
            $this->addConfig($c);
        endforeach;

        do_action("after_theme_init_config");
    }

    /**
     * Add theme config from /app/etc/
     *
     * @param $key string File name of config from /app/etc/ without extension
     */
    public function addConfig($key)
    {
        do_action("before_theme_add_config", $key);

        $base_path = get_template_directory();
        $config_path = $base_path . "/app/etc/core/";
        if (!isset($this->configs[$key])):
            $parsed = Yaml::parse(file_get_contents($config_path . $key . ".yaml"));
            if (is_array($parsed)):
                $this->setConfig(array_merge($parsed, $this->getConfig()));
            endif;
        endif;

        do_action("after_theme_add_config", $key);
    }

    /**
     * Set wrapper of the template
     *
     * @param $wrapper string Name of wrapper from wrappers.yaml
     */
    public function setWrapper($wrapper)
    {
        do_action("before_theme_set_wrapper", $wrapper);

        $this->wrapper = $wrapper;

        do_action("after_theme_set_wrapper", $wrapper);
    }

    /**
     * Set sections that will be rendered. /app/etc/sections.yaml
     *
     * @param $sections array Syntax: array("key" => "location",...)
     */
    public function setSections(array $sections)
    {
        do_action("before_theme_set_sections", $sections);

        $this->sections = $sections;

        do_action("before_theme_set_sections", $sections);
    }

    /**
     * Render template
     *
     * @param bool|string $wrapper Same as theme()->setWrapper(...)
     * @param bool|array $sections Same as theme()->setSections(...)
     */
    public function render($wrapper = false, $sections = false)
    {
        do_action("before_theme_render");

        if ($wrapper):
            $this->setWrapper($wrapper);
        endif;

        if ($sections):
            $this->setSections($sections);
        endif;

        $wrappers = $this->getConfig("wrappers");
        $wrapper = $this->wrapper;

        if ($wrapper && isset($wrappers[$wrapper]) && isset($wrappers[$wrapper]["template"])):
            include get_template_directory() . "/" . $wrappers[$wrapper]["template"];
        else:
            die("Wrapper not found, or is not set.");
        endif;

        do_action("after_ntl_render");
    }

    /**
     * Render sections of given location inside wrapper
     *
     * @param $location string Render sections on this location
     */
    public function getContent($location)
    {
        do_action("before_theme_get_content");

        foreach ($this->sections as $key => $place):

            # skip if section is not in given location
            if ($place != $location || !isset($this->getConfig("sections")[$key])):
                continue;
            endif;

            # Get some required things
            $sectionTemplate = $this->getConfig("sections")[$key]["template"];

            do_action("before_theme_section_" . $key . "_render");

            # If cache is enabled and runtime is production and... then do cache
            if ($this->getConfig("sections")[$key]["cache"] && $this->production && !is_user_logged_in() && !$this->is_post_req && !$this->is_ajax):
                $cache = $this->module("ThemeCache")->getCache($sectionTemplate);
                echo $cache !== false ? $cache : $this->module("ThemeCache")->doCache($sectionTemplate);
            else:
                include get_template_directory() . "/" . $sectionTemplate;
            endif;

            do_action("after_theme_section_" . $key . "_render");

        endforeach;

        do_action("after_theme_get_content");
    }
}