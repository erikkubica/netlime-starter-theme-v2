<?php if (!have_posts()) : ?>
    <article itemscope itemtype="http://schema.org/ScholarlyArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
        <?php get_template_part('templates/page', 'header'); ?>
        <div class="content nofter" itemprop="articleBody">
            <p>
                <?php _e('Sorry, no results were found.', 'sage'); ?>
            </p>
        </div>
    </article>
<?php else: ?>
    <article itemscope itemtype="http://schema.org/ScholarlyArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
        <?php get_template_part('templates/page', 'header'); ?>
    </article>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content'); ?>
<?php endwhile; ?>
<?php the_posts_navigation(); ?>