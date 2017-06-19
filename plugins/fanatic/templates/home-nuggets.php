
<div class=" [ one-fifth up-to-third ] sub-section">
    <?php edit_post_link(); ?>
    <?php if ( has_post_thumbnail() ) { ?>
    <?php the_post_thumbnail(); ?>
    <?php } ?>
    <h4><?php the_title(); ?></h4>
    <p><?php the_content(); ?></p>
</div>
