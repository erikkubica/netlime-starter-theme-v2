<h4>
    <?php echo sprintf(__('Search Results for "%s"', 'theme'), get_search_query()) ?>
</h4>

<?php if (!have_posts()) : ?>
    <?= __('Sorry, no results were found.', 'theme'); ?>
<?php endif; ?>