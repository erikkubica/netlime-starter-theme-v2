<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075
{
    public static $classMap = array (
        'ComposerAutoloaderInit82b81877f4a9b1d97b93740bfd0c9075' => __DIR__ . '/..' . '/composer/autoload_real.php',
        'Composer\\Autoload\\ClassLoader' => __DIR__ . '/..' . '/composer/ClassLoader.php',
        'Composer\\Autoload\\ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075' => __DIR__ . '/..' . '/composer/autoload_static.php',
        'Menu_Item_Megamenu_Fields_Walker' => __DIR__ . '/..' . '/netlime-theme/megamenu/Menu_Item_Megamenu_Fields_Walker.php',
        'NetLimeTheme\\Core\\Lib\\ThemeModuleBase' => __DIR__ . '/..' . '/netlime-theme/core/lib/ThemeModuleBase.php',
        'NetLimeTheme\\Core\\Lib\\ThemeSectionBase' => __DIR__ . '/..' . '/netlime-theme/core/lib/ThemeSectionBase.php',
        'NetLimeTheme\\Core\\Lib\\ThemeSectionBaseInterface' => __DIR__ . '/..' . '/netlime-theme/core/lib/ThemeSectionBaseInterface.php',
        'NetLimeTheme\\Core\\Theme' => __DIR__ . '/..' . '/netlime-theme/core/Theme.php',
        'NetLimeTheme\\Extensions\\ThemeAssets' => __DIR__ . '/..' . '/netlime-theme/assets/ThemeAssets.php',
        'NetLimeTheme\\Extensions\\ThemeCache' => __DIR__ . '/..' . '/netlime-theme/cache/ThemeCache.php',
        'NetLimeTheme\\Extensions\\ThemeDebug' => __DIR__ . '/..' . '/netlime-theme/debug/ThemeDebug.php',
        'NetLimeTheme\\Extensions\\ThemeDisableEmoji' => __DIR__ . '/..' . '/netlime-theme/disableemoji/ThemeDisableEmoji.php',
        'NetLimeTheme\\Extensions\\ThemeImage' => __DIR__ . '/..' . '/netlime-theme/image/ThemeImage.php',
        'NetLimeTheme\\Extensions\\ThemeMegaMenu' => __DIR__ . '/..' . '/netlime-theme/megamenu/ThemeMegaMenu.php',
        'NetLimeTheme\\Extensions\\ThemeMenu' => __DIR__ . '/..' . '/netlime-theme/menu/ThemeMenu.php',
        'NetLimeTheme\\Extensions\\ThemeNavigation' => __DIR__ . '/..' . '/netlime-theme/navigation/ThemeNavigation.php',
        'NetLimeTheme\\Extensions\\ThemePagination' => __DIR__ . '/..' . '/netlime-theme/pagination/ThemePagination.php',
        'NetLimeTheme\\Extensions\\ThemeSidebars' => __DIR__ . '/..' . '/netlime-theme/sidebars/ThemeSidebars.php',
        'NetLimeTheme\\Extensions\\ThemeSupports' => __DIR__ . '/..' . '/netlime-theme/supports/ThemeSupports.php',
        'NetLimeTheme\\Extensions\\ThemeTitle' => __DIR__ . '/..' . '/netlime-theme/title/ThemeTitle.php',
        'NetLimeTheme\\Sections\\Comments' => __DIR__ . '/../..' . '/view/sections/comments/Comments.php',
        'NetLimeTheme\\Sections\\Footer' => __DIR__ . '/../..' . '/view/sections/footer/Header.php',
        'NetLimeTheme\\Sections\\Header' => __DIR__ . '/../..' . '/view/sections/header/Header.php',
        'NetLimeTheme\\Sections\\NotFound' => __DIR__ . '/../..' . '/view/sections/404/NotFound.php',
        'NetLimeTheme\\Sections\\Page' => __DIR__ . '/../..' . '/view/sections/page/Page.php',
        'NetLimeTheme\\Sections\\Pagination' => __DIR__ . '/../..' . '/view/sections/pagination/Pagination.php',
        'NetLimeTheme\\Sections\\Post' => __DIR__ . '/../..' . '/view/sections/post/Post.php',
        'NetLimeTheme\\Sections\\PostList' => __DIR__ . '/../..' . '/view/sections/post/PostList.php',
        'NetLimeTheme\\Sections\\Search' => __DIR__ . '/../..' . '/view/sections/search/Search.php',
        'NetLimeTheme\\Sections\\SidebarLeft' => __DIR__ . '/../..' . '/view/sections/sidebar/SidebarLeft.php',
        'NetLimeTheme\\Sections\\SidebarRight' => __DIR__ . '/../..' . '/view/sections/sidebar/SidebarRight.php',
        'NetLimeTheme\\Sections\\Test' => __DIR__ . '/../..' . '/view/sections/test/Test.php',
        'wp_bootstrap_navwalker' => __DIR__ . '/..' . '/netlime-theme/menu/lib/wp_bootstrap_navwalker.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit82b81877f4a9b1d97b93740bfd0c9075::$classMap;

        }, null, ClassLoader::class);
    }
}
