<?php
namespace NetLimeTheme\Core\Lib;

class ThemeModuleBase
{
    private $config = [];

    function __construct()
    {
        $this->initConfig();
    }

    protected function initConfig()
    {
        $class_info = new \ReflectionClass($this);
        $child_dir = dirname($class_info->getFileName());
        $basename = basename($child_dir);

        # Check if there is config for override
        $templateConfigDirectory = get_template_directory() . "/etc/";

        if (file_exists($templateConfigDirectory . $basename . "/config.json")):
            $conf = json_decode(file_get_contents($templateConfigDirectory . $basename . "/config.json"), true);
            $this->setConfig($conf);
            return;
        endif;

        # If no override then include config from inside plugin
        if (file_exists($child_dir . "/config.json")):
            $conf = json_decode(file_get_contents($child_dir . "/config.json"), true);
            $this->setConfig($conf);
        endif;

        return;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getConfig($key = false)
    {
        do_action("before_theme_config_" . $key . "_get", $key, $this->config);

        if ($key):
            return $this->config[$key];
        else:
            return $this->config;
        endif;
    }

    public function setConfig($config)
    {
        do_action("before_theme_config_set", $this->config);

        $this->config = $config;

        do_action("after_theme_config_set", $this->config);
    }

}