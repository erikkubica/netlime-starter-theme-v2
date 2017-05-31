<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075
{
    public static $classMap = array (
        'ComposerAutoloaderInit82b81877f4a9b1d97b93740bfd0c9075' => __DIR__ . '/..' . '/composer/autoload_real.php',
        'Composer\\Autoload\\ClassLoader' => __DIR__ . '/..' . '/composer/ClassLoader.php',
        'Composer\\Autoload\\ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075' => __DIR__ . '/..' . '/composer/autoload_static.php',
        'Menu_Item_Megamenu_Fields_Walker' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/megamenu/Menu_Item_Megamenu_Fields_Walker.php',
        'NetLimeTheme\\Core\\Lib\\ThemeModuleBase' => __DIR__ . '/..' . '/netlime-starter-theme/core/lib/ThemeModuleBase.php',
        'NetLimeTheme\\Core\\Theme' => __DIR__ . '/..' . '/netlime-starter-theme/core/Theme.php',
        'NetLimeTheme\\Extensions\\ThemeAssets' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/assets/ThemeAssets.php',
        'NetLimeTheme\\Extensions\\ThemeCache' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/cache/ThemeCache.php',
        'NetLimeTheme\\Extensions\\ThemeDebug' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/debug/ThemeDebug.php',
        'NetLimeTheme\\Extensions\\ThemeDisableEmoji' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/disableemoji/ThemeDisableEmoji.php',
        'NetLimeTheme\\Extensions\\ThemeImage' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/image/ThemeImage.php',
        'NetLimeTheme\\Extensions\\ThemeMegaMenu' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/megamenu/ThemeMegaMenu.php',
        'NetLimeTheme\\Extensions\\ThemeMenu' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/menu/ThemeMenu.php',
        'NetLimeTheme\\Extensions\\ThemeNavigation' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/navigation/ThemeNavigation.php',
        'NetLimeTheme\\Extensions\\ThemePagination' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/pagination/ThemePagination.php',
        'NetLimeTheme\\Extensions\\ThemeSidebars' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/sidebars/ThemeSidebars.php',
        'NetLimeTheme\\Extensions\\ThemeSupports' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/supports/ThemeSupports.php',
        'NetLimeTheme\\Extensions\\ThemeTitle' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/title/ThemeTitle.php',
        'wp_bootstrap_navwalker' => __DIR__ . '/..' . '/netlime-starter-theme/extensions/menu/lib/wp_bootstrap_navwalker.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075::$classMap;

        }, null, ClassLoader::class);
    }
}
