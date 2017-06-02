<article class="panel panel-default">
    <header class="panel-header">
        <img src="<?= theme()->module("ThemeImage")->getImage(get_post_thumbnail_id(), "home-thumbnail") ?>" class="img-responsive" alt="<?= get_the_title()?>" />
    </header>
    <div class="panel-body">
        <h2><?php the_title() ?></h2>
        <?php the_content() ?>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'theme'), 'after' => '</p></nav>']); ?>
    </div>
    <footer class="panel-footer text-right">
        <?php get_template_part('templates/entry-meta'); ?>
    </footer>
</article>