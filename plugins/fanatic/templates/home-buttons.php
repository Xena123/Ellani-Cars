<?php if (current_user_can('manage_options')) { ?>
<div style="display:inline;">
    <?php edit_post_link(); ?>
</div>
<?php } ?>
<a href="<?php the_field('link'); ?>" class=" [ button-link button-link--l ] [ one-fifth up-to-third ] ">
    <?php the_field('label'); ?>
</a>
