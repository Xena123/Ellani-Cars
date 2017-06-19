<section class="o-wrap--padding-100 u-flex-column u-padding-top-30 u-padding-bottom-50">
  <?php
    $args = array (
      'post_type' => 'vehicles',
      'posts_per_page' => 5,
      'orderby' => 'date',
      'order' => 'DESC',
      'paged' => get_query_var( 'paged' ),
    );
    $wp_query = new WP_Query( $args );
    if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
  ?>
  <article class="u-border-bottom">
  	<div class="c-category-vehicle u-flex u-padding-bottom-20 u-padding-top-20">
  		<div class="o-content-block-third-width u-margin-20 u-relative">
  		  <a href="<?php the_permalink(); ?>">
          <div class="o-content-block__img " style="background-image: url('<?php the_post_thumbnail_url('large'); ?>')">
          </div>
          <?php echo get_field('sold') ? '<div class="o-background u-overlay--sold"></div>' : '' ?>
        </a>
		  </div>
		  <div class="o-content-block-two-thirds-width">
			  <header class="u-flex--init u-flex-space-between u-flex-center u-padding-bottom-10 u-text-black">
          <?php edit_post_link(); ?>
			  	<a href="<?php the_permalink(); ?>"><h2 class="u-inline-block u-uppercase"><?php the_title(); ?></h2></a>
			  	<h2 class="u-inline-block u-uppercase">£<?php the_field('price') ?></h2>
			  </header>
		  	<div class="u-flex--init u-flex-start u-flex-center u-padding-bottom-20 u-text-black">
		  		<h5 class="u-uppercase u-fw-600 u-border-right u-padding-top-and-bottom-2 u-padding-right-25"><?php the_field('year'); ?></h5>
		  		<h5 class="u-uppercase u-fw-600 u-border-right u-padding-button-25"><?php the_field('mileage'); ?> Miles</h5>
		  		<h5 class="u-uppercase u-fw-600 u-border-right u-padding-button-25"><?php the_field('transmission'); ?></h5>
		  		<h5 class="u-uppercase u-fw-600 u-border-right u-padding-button-25 u-margin-right-25"><?php the_field('engine'); ?>L</h5>
		  		<h5 class="u-uppercase u-fw-600 u-padding-top-and-bottom-2"><?php the_field('fuel'); ?></h5>
		  	</div>
        <div class="o-content u-padding-bottom-20 u-text-dark-grey">
  		  	<?php the_content(); ?>
        </div>
		  	<div class="u-flex--init--1000 u-flex-space-between u-flex-center">
		  		<a href="#" class="u-flex--init u-flex-center u-flex-justify-center u-padding-top-and-bottom-5">
			        <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/link_insurance.png" class="u-inline-block u-margin-right-10">
			        <span class="u-uppercase">Insurance Quote</span>
		        </a>
		        <a href="#" class="u-flex--init u-flex-center u-flex-justify-center u-padding-top-and-bottom-5">
			        <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/link_history.png" class="u-inline-block u-margin-right-10">
			        <span class="u-uppercase">Check Its History</span>
			    </a>
			    <a href="<?php the_permalink(); ?>" class="c-animate u-background--dark-blue u-uppercase u-text-white u-padding-top-and-bottom-5 u-flex--init u-flex-center u-flex-justify-center">
		            <p class="u-inline-block u-padding-button-25">Find Out More</p>
		            <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right.png" class="c-caret-right u-inline-block u-padding-right-10">
		        </a>
		    </div>
	    </div>
    </div>
  </article>

	<?php endwhile; endif; wp_reset_postdata(); ?>
   <nav class="c-vehicle-pagination">
    <?php previous_posts_link('&laquo; Previous') ?>
    <?php next_posts_link('Next &raquo;') ?>
</nav>
</section>
