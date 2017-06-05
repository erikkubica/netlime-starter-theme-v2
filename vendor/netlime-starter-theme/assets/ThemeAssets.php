<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeAssets extends ThemeModuleBase
{
    public function init()
    {
        $this->registerAssets();
    }

    /**
     * Register css and js from config
     */
    protected function registerAssets()
    {
        do_action("before_theme_register_assets");

        $assets = $this->getConfig("assets");

        add_action("wp_enqueue_scripts", function () use ($assets) {
            foreach ($assets as $id => $asset) :
                $file = strpos($asset["file"], "//") === false ? get_template_directory_uri() . "/public/" . $asset["file"] : $asset["file"];
                if ($asset["type"] == "js") :
                    wp_enqueue_script($id, $file, $asset["dependencies"], $asset["version"], $asset["footer"]);
                elseif ($asset["type"] == "css") :
                    wp_enqueue_style($id, $file, $asset["dependencies"], $asset["version"], "all");
                endif;
            endforeach;
        });

        do_action("after_theme_register_assets");
    }
}