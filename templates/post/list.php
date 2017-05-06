<?php while (have_posts()): the_post(); ?>
    <article class="panel panel-default">
        <header class="panel-header">
            <img src="<?= theme()->module("ThemeImage")->getImage(get_post_thumbnail_id(), "home-thumbnail") ?>" class="img-responsive" alt="<?= get_the_title() ?>"/>
        </header>
        <div class="panel-body">
            <h2><?php the_title() ?></h2>
            <?php get_template_part("templates/entry-meta"); ?>
            <p><?php the_excerpt() ?></p>
        </div>
        <footer class="panel-footer text-right">
            <a href="<?= get_the_permalink() ?>" class="btn btn-primary"><?= __("Read More »", "theme") ?></a>
        </footer>
    </article>
<?php endwhile; ?>