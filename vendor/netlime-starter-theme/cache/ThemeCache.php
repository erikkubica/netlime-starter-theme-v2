<?php

namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;
use NetLimeTheme\Core\Lib\ThemeSectionBase;

class ThemeCache extends ThemeModuleBase
{
    protected $cachePath = WP_CONTENT_DIR . "/cache/theme/";
    protected $sectionsRendered = [];

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
     * @param $cacheKey
     * @return string
     */
    public function getCacheFile($cacheKey)
    {
        do_action("before_theme_get_cache_file", $cacheKey);

        $filename = md5($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "-" . $cacheKey);

        do_action("after_theme_get_cache_file", $filename);

        return $this->cachePath . $filename;
    }

    /**
     * Create the cache
     *
     * @param string $sectionKey Key of section as registered
     * @param ThemeSectionBase $section Section
     *
     * @return string Cached content
     */
    public function doCache($sectionKey, &$section)
    {
        do_action("before_theme_do_cache", $sectionKey);

        $cacheKey = $this->getCacheKey($sectionKey, $section);

        # Get cache file absolute path
        $file = $this->getCacheFile($cacheKey);

        # Start buffering output
        ob_start();

        # Render the template
        $section->init();
        $section->render();

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
     * @param $sectionKey
     * @param ThemeSectionBase $section Section
     * @return bool|mixed|string
     */
    public function getCache($sectionKey, &$section)
    {
        do_action("before_theme_get_cache", $sectionKey);

        $cacheKey = $this->getCacheKey($sectionKey, $section);

        # Get cache file absolute path
        $file = $this->getCacheFile($cacheKey);

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

    protected function getCacheKey(&$sectionKey, &$section)
    {
        if ($section->data !== []):
            return $sectionKey . md5(json_encode($section->data));
        endif;

        return $sectionKey;
    }

}