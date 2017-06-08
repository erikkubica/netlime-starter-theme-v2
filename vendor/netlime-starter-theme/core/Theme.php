<?php

namespace NetLimeTheme\Core;

use NetLimeTheme\Core\Lib\ThemeModuleBase;
use NetLimeTheme\Core\Lib\ThemeSectionBase;

class Theme extends ThemeModuleBase
{
    protected $modules = [];

    protected $production = false;
    protected $registeredSections = [];
    protected $registeredWrappers = [];

    protected $sections = [];
    protected $wrapper = false;

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

        # Register wrappers
        do_action("before_theme_register_wrappers");
        do_action("on_theme_register_wrappers");
        do_action("after_theme_register_wrappers");

        # Register sections
        do_action("before_theme_register_sections");
        do_action("on_theme_register_sections");
        do_action("after_theme_register_sections");

        do_action("after_theme_setup");
    }

    /**
     * Auto load extensions
     */
    protected function autoLoadModules()
    {
        $extDirectory = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
        $extDirectories = glob($extDirectory . "*", GLOB_ONLYDIR);

        foreach ($extDirectories as $directory):
            if (basename($directory) === "core"):
                continue;
            endif;

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
        do_action("before_theme_module_register");
        apply_filters("before_theme_module_init", $key, $instance);

        $this->modules[$key] = $instance;
        $this->module($key)->init();

        apply_filters("after_theme_module_init", $key, $instance);
        do_action("after_theme_module_register");
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
     * Register section to theme. Can be used to override already registered.
     *
     * @param string $sectionKey Class name of section to keep some convention
     * @param string $instance Instance of section
     */
    public function registerSection($sectionKey, $instance)
    {
        //$this->registeredSections[$sectionKey] = (object)["template" => $template_path, "cache" => $cache, "is_class" => $is_class];

        $this->registeredSections[$sectionKey] = $instance;
    }

    /**
     * Get section by it´s key
     *
     * @param string $sectionKey
     * @return \NetLimeTheme\Core\Lib\ThemeSectionBase
     * @throws \Exception
     */
    public function getRegisteredSection($sectionKey)
    {
        if (!isset($this->registeredSections[$sectionKey])):
            throw new \Exception("Section \"$sectionKey\" is not registered. Registered sections: " . implode(", ", array_keys($this->registeredSections)));
        endif;

        return $this->registeredSections[$sectionKey];
    }

    /**
     * Register wrapper to theme. Can be used to override already registered.
     *
     * @param string $wrapperKey Key that you will referring in templates
     * @param string $template_path Relative path to php file in theme directory ex.: "wrappers/1column.php"
     */
    public function registerWrapper($wrapperKey, $template_path)
    {
        $this->registeredWrappers[$wrapperKey] = (object)["template" => $template_path];
    }

    /**
     * Get wrapper by it´s key
     *
     * @param string $wrapperKey
     * @return \stdClass
     * @throws \Exception
     */
    public function getRegisteredWrapper($wrapperKey)
    {
        if (!isset($this->registeredWrappers[$wrapperKey])):
            throw new \Exception("Wrapper \"$wrapperKey\" is not registered.. Registered wrappers: " . implode(", ", array_keys($this->registeredWrappers)));
        endif;

        return $this->registeredWrappers[$wrapperKey];
    }

    /**
     * Set wrapper of the template
     *
     * @param $wrapperKey string Key of wrapper
     */
    public function setWrapper($wrapperKey)
    {
        do_action("before_theme_set_wrapper", $wrapperKey);

        $this->wrapper = $wrapperKey;

        do_action("after_theme_set_wrapper", $wrapperKey);
    }

    /**
     * Set sections that will be rendered.
     *
     * @param $sections array Syntax: array("sectionKey" => "location",...)
     */
    public function setSections(array $sections)
    {
        do_action("before_theme_set_sections", $sections);

        $this->sections = $sections;

        do_action("after_theme_set_sections", $sections);
    }

    /**
     * Render template
     *
     * @param bool|string $wrapperKey Same as theme()->setWrapper(...)
     * @param bool|array $sections Same as theme()->setSections(...)
     */
    public function render($wrapperKey = false, $sections = false)
    {
        do_action("before_theme_render");

        if ($wrapperKey):
            $this->setWrapper($wrapperKey);
        endif;

        if ($sections):
            $this->setSections($sections);
        endif;

        $wrapper = $this->getRegisteredWrapper($this->wrapper);

        include get_template_directory() . "/" . $wrapper->template;

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
        apply_filters("before_theme_get_content", $location);

        foreach ($this->sections as $section_data):

            # Skip if section is not in given location
            if ($section_data[1] !== $location):
                continue;
            endif;

            # Render it
            $this->renderSection($section_data[0]);

        endforeach;

        apply_filters("after_theme_get_content", $location);
        do_action("after_theme_get_content");
    }


    /**
     * Render section
     *
     * @param string $sectionKey The key of section used when registered
     * @param array $data Section data to render with
     */
    public function renderSection($sectionKey, $data = [])
    {
        # Get the section
        $section = $this->getRegisteredSection($sectionKey);

        # Set section data
        $section->data = &$data;

        do_action("before_theme_section_" . $sectionKey . "_render");
        apply_filters("before_theme_section_render", $sectionKey);

        # If needed do something before render without hook
        $section->beforeRender();

        # If cache is enabled and runtime is production and... then do cache
        if ($section->cache && $this->production && !is_user_logged_in() && !$this->is_post_req && !$this->is_ajax):
            $cache = $this->module("ThemeCache")->getCache($sectionKey, $section);
            echo $cache !== false ? $cache : $this->module("ThemeCache")->doCache($sectionKey, $section);
        else:
            $section->init();
            $section->render();
        endif;

        # If needed do something after render without hook
        $section->afterRender();

        apply_filters("after_theme_section_render", $sectionKey);
        do_action("after_theme_section_" . $sectionKey . "_render");
    }

    public function isProduction()
    {
        return $this->production;
    }
}