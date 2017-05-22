<?php
namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeCache extends ThemeModuleBase
{
    protected $cachePath = WP_CONTENT_DIR . "/cache/theme/";

    public function init()
    {
        do_action("before_theme_cache_init");

        $this->setupCacheDirectory();
        $this->flushOldCache();
        $this->setupFlushCache();

        do_action("after_theme_cache_init");
    }

    protected function setupCacheDirectory()
    {
        do_action("before_theme_cache_setup_directory");

        if (!file_exists($this->cachePath)):
            mkdir($this->cachePath, 0755, true);
        endif;

        do_action("before_theme_cache_setup_directory");
    }

    /**
     * Registers link & action for it on admin bar to flush cache
     */
    protected function setupFlushCache()
    {
        do_action("before_theme_setup_flush_cache");

        # Add flush cache link to admin bar
        add_action('admin_bar_menu', function ($wp_admin_bar) {
            $args = array(
                'id' => 'cache_flush_link',
                'title' => 'Flush cache',
                'href' => get_admin_url() . '?flushCache',
                'meta' => array('class' => 'cache-flush-link')
            );
            $wp_admin_bar->add_node($args);
        }, 999);

        # Force cleat all cache, otherwise just remove old
        if (isset($_GET["flushCache"]) && is_admin() && is_user_logged_in()):
            $this->flushCache();
            $this->doNotice(__("Cache has been flushed."));
        endif;

        do_action("after_theme_setup_flush_cache");
    }

    /**
     * Show notice in admin area
     *
     * @param $message string A notice message
     */
    protected function doNotice($message)
    {
        do_action("before_theme_notice");

        add_action('admin_notices', function () use ($message) {
            echo '<div class="notice notice-success is-dismissible">
                <p>' . $message . '</p>
        </div>';
        });

        do_action("after_theme_notice");
    }

    /**
     * Force clear all cached files
     */
    protected function flushCache()
    {
        do_action("before_theme_flush_cache");

        wp_cache_flush();
        array_map("unlink", glob($this->cachePath . "*"));

        do_action("after_theme_flush_cache");
    }

    /**
     * Clears all cached files that is older than specified cache lifetime
     * because sometimes bots are requesting urls that is visited only once and
     * after a while there will be thousands of files without any reason.
     */
    protected function flushOldCache()
    {
        do_action("before_theme_flush_old_cache");

        $files = glob($this->cachePath . "*");
        $files = (is_array($files) && $files ? $files : array());

        $cache_config = $this->getConfig("cache");

        foreach ($files as $file):
            if (file_exists($file) && (time() - filemtime($file) > $cache_config["lifetime"])):
                unlink($file);
            endif;
        endforeach;

        do_action("after_ntl_flush_old_cache");
    }

    /**
     * Get absolute path of cache file
     *
     * @param $sectionTemplate
     * @return string
     */
    public function getCacheFile($sectionTemplate)
    {
        do_action("before_theme_get_cache_file", $sectionTemplate);

        $filename = md5($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "-" . $sectionTemplate);

        do_action("after_theme_get_cache_file", $filename);

        return $this->cachePath . $filename;
    }

    /**
     * Create the cache
     *
     * @param $sectionTemplate string Name of the template
     * @return string Cached content
     */
    public function doCache($sectionTemplate)
    {
        do_action("before_theme_do_cache", $sectionTemplate);

        # Get cache file absolute path
        $file = $this->getCacheFile($sectionTemplate);

        # Start buffering output
        ob_start();

        # Render the template
        include get_template_directory() . "/" . $sectionTemplate;

        $cacheConfig = $this->getConfig("cache");

        # Minify the output
        if ($cacheConfig["minify"]):
            $cache = str_replace(["  ", "\n", "\t"], ["", "", ""], ob_get_clean());
        else:
            $cache = ob_get_clean();
        endif;

        # Write output to memory or file
        if ($cacheConfig["type"] == "wp_cache"):
            wp_cache_add(basename($file), $cache, "sections_cache", $cacheConfig["lifetime"]);
        else:
            # Delete file if already exists
            if (file_exists($file)):
                unlink($file);
            endif;

            # Prevents creating empty cache file
            if (!empty($cache) || $cache != ""):
                file_put_contents($file, $cache);
            endif;
        endif;

        do_action("after_theme_do_cache", $cache);

        # Return output
        return $cache;
    }

    /**
     * Get cached html
     *
     * @param $sectionTemplate
     * @return bool|mixed|string
     */
    public function getCache($sectionTemplate)
    {
        do_action("before_theme_get_cache", $sectionTemplate);

        # Get cache file absolute path
        $file = $this->getCacheFile($sectionTemplate);

        # Define variable with false
        $cache = false;

        $cacheConfig = $this->getConfig("cache");

        # TODO: When not redis, than wp_cache wont load from cache
        # Get cached html depending on cache type
        if ($cacheConfig["type"] == "wp_cache"):
            $cache = wp_cache_get(basename($file), "sections_cache");
        else:
            if (file_exists($file) && (time() - filemtime($file) < $cacheConfig["lifetime"])):
                $cache = file_get_contents($file);
            endif;
        endif;

        do_action("after_ntl_get_cache", $cache);

        # Return cached html
        return $cache;
    }
}