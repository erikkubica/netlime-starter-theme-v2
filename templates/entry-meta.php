<div class="hidden-xs"><?= __("by") ?>
    <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" itemprop="author" itemscope
       itemtype="https://schema.org/Person"
    ><?= get_the_author(); ?></a>
    &nbsp;<?= __("at") ?>&nbsp;
    <time itemprop="datePublished" datetime="<?= get_the_time("d. M Y") ?>"><?= get_the_time("d. M Y") ?></time>
    <meta itemprop="dateModified" content="<?= get_the_modified_time("d. M Y") ?>"/>
</div>