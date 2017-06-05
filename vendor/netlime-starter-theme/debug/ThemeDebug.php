<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeDebug extends ThemeModuleBase
{
    public $debug = [];
    public $start = 0;

    public function init()
    {
        $this->start = microtime(true);
        $this->runDebug();
    }

    protected function runDebug()
    {
        add_filter("before_theme_section_render", array($this, "recordMicrotime"));
        add_action("after_theme_section_render", array($this, "debugSections"));

        add_action("before_theme_module_init", array($this, "recordMicrotime"));
        add_action("after_theme_module_init", array($this, "debugModules"));

        add_action("wp_footer", array($this, "renderDebugFooter"));
    }

    public function recordMicrotime()
    {
        $this->start = microtime(true);
    }

    public function debugSections($location)
    {
        $this->debug["sections"][] = "Section <b>$location</b> rendered in <b>" . number_format(microtime(true) - $this->start, 10) . "</b> seconds";
    }

    public function debugModules($key)
    {
        $this->debug["modules"][] = "Module <b>$key</b> initialised in <b>" . number_format(microtime(true) - $this->start, 10) . "</b> seconds";
    }

    public function renderDebugFooter()
    {
        ?>
        <div style="position: fixed; bottom:0;left:0; width: 100%;background-color: #e0e0e0;color:black;padding: 2rem;">
            Production mode is <?= theme()->isProduction() ? "<span style='color:green'>enabled</span>" : "<span style='color:red'>disabled</span>" ?>
            <br/>
            Use ?devmode or &devmode to enable developer mode without caching
            <br/>
            <div class="row">
                <div class="col-md-4">
                    <h4>Sections</h4>
                    <?php foreach ($this->debug["sections"] as $section_info): ?>
                        <?= $section_info; ?><br/>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <h4>Modules loaded</h4>
                    <?php foreach ($this->debug["modules"] as $section_info): ?>
                        <?= $section_info; ?><br/>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}