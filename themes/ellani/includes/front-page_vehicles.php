      <section class="o-wrap--full-width u-flex-wrap">
        <?php
          $args = array (
            'post_type' => 'vehicles',
            'cat' => 1,
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
          );
          $wp_query = new WP_Query( $args );
          if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
        ?>

    		<article class="o-content-block-wrap o-content-block-third-width--homepage">

          <div class="o-content-block u-relative u-box-height--260 u-text-center">
            <div class="o-background">
              <div class="c-front-page__slider-img" style="background-image: url('<?php the_post_thumbnail_url('large'); ?>');"></div>
            </div>
            <?php echo get_field('sold') ? '<div class="o-background u-overlay--sold"></div>' : '' ?>
            <div class="o-background u-overlay--dark-on-hover"></div>
            <div class="u-relative u-text-white o-hover-text u-opacity-hover">
              <img src="<?php the_field('icon'); ?>" class="c-content-block__icon u-padding-bottom-15">
              <h3 class="u-padding-bottom-20 u-uppercase u-bold"><?php the_title(); ?></h3>
              <h5 class="u-uppercase u-padding-bottom-5 u-bold"><?php the_field('mileage'); ?> Miles</h5>
              <h5 class="u-padding-bottom-20">£<?php the_field('price'); ?></h5>
              <a href="<?php the_permalink(); ?>" class="u-border-button u-padding-button-15">
                <p class="u-inline-block u-uppercase"><?php the_field('link_label'); ?></p>
                <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right.png" class="u-inline-block u-padding-left-15">
              </a>
            </div>
          </div>

    		</article>


      <?php endwhile; endif; wp_reset_postdata(); ?>

      </section>
