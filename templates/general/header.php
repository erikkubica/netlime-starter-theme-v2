<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= esc_url(home_url('/')) ?>">
                <?php bloginfo("name") ?>
            </a>
        </div>

        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary-navigation',
            'container' => 'div',
            'container_class' => 'navbar-collapse collapse',
            'container_id' => 'navbar',
            'menu_class' => 'nav navbar-nav',
            'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
            'walker' => new wp_bootstrap_navwalker()
        ));
        ?>
    </div>
</nav>